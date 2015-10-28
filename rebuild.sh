#!/bin/bash
BASEDIR=`php -r "echo dirname(realpath('$0'));"`
OLDDIR=`pwd`
cd $BASEDIR

function ensureIsWritable() {
  chmod ug+w $1
  LAST_RETURN_VALUE=$?
  if [ $LAST_RETURN_VALUE -ne 0 ]; then
    echo "Error: There was a problem making '$1' writable."
    exit 1
  fi
}

function ensureCurrentUserIsOwner() {
  CURRENT_USER=`whoami`
  OWNER=`ls -ld "$1" | awk '{print $3}'`
  if [ "$CURRENT_USER" != "$OWNER" ]; then
    echo "Error: File or dir '$1' is not owned by user '$CURRENT_USER'. Aborting."
    exit 1
  fi
}

# Try moving ./public_html/sites/default/files to ./assets/files if it is still an actual directory.
if [ -d ./public_html/sites/default/files -a ! -h ./public_html/sites/default/files ]; then
  # Drupal files directory is still a directory AND NOT a symlink (to ./assets/files)
  if [ -d ./assets/files ]; then
    echo "Error: Unable to move directory ./public_html/sites/default/files to ./assets/files because ./assets/files is a directory already. Aborting so that this can be taken care of."
    exit 1
  else
    if [ -a ./assets/files ]; then
      rm -rf ./assets/files
      LAST_RETURN_VALUE=$?
      if [ $LAST_RETURN_VALUE -ne 0 ]; then
        echo "Error: There was a problem with removing a non-directory ./assets/files . Aborting so that this can be taken care of."
        exit 1
      fi
    fi
  fi
  ensureIsWritable ./public_html/sites/default
  ensureCurrentUserIsOwner ./public_html/sites/default
  ensureIsWritable ./public_html/sites/default/files
  ensureCurrentUserIsOwner ./public_html/sites/default/files
  mv ./public_html/sites/default/files ./assets/files
  LAST_RETURN_VALUE=$?
  if [ $LAST_RETURN_VALUE -ne 0 ]; then
    echo "Error: There was a problem with moving ./public_html/sites/default/files to ./assets/files . Aborting so that this can be taken care of."
    exit 1
  fi
fi

# Try moving ./public_html/sites/default/settings.php to ./assets/settings.php if it is still an actual file.
if [ -f ./public_html/sites/default/settings.php -a ! -h ./public_html/sites/default/settings.php ]; then
  # settings.php is still a regular file AND NOT a symlink (to ./assets/settings.php)
  if [ -f ./assets/settings.php ]; then
    echo "Error: Unable to move directory ./public_html/sites/default/settings.php to ./assets/settings.php because ./assets/settings.php is a regular file already. Aborting so that this can be taken care of."
    exit 1
  else
    if [ -a ./assets/settings.php ]; then
      rm -rf ./assets/settings.php
      LAST_RETURN_VALUE=$?
      if [ $LAST_RETURN_VALUE -ne 0 ]; then
        echo "Error: There was a problem with removing a non-regular-file ./assets/settings.php . Aborting so that this can be taken care of."
        exit 1
      fi
    fi
  fi
  ensureIsWritable ./public_html/sites/default
  ensureCurrentUserIsOwner ./public_html/sites/default
  ensureIsWritable ./public_html/sites/default/settings.php
  ensureCurrentUserIsOwner ./public_html/sites/default/settings.php
  mv ./public_html/sites/default/settings.php ./assets/settings.php
  LAST_RETURN_VALUE=$?
  if [ $LAST_RETURN_VALUE -ne 0 ]; then
    echo "Error: There was a problem with moving ./public_html/sites/default/settings.php to ./assets/settings.php . Aborting so that this can be taken care of."
    exit 1
  fi
fi

# Read paths_to_keep.txt and get rid of all comments and empty lines
php --process-code '$x = trim(preg_replace("/\s*#.*\$/", "", $argn)); if ($x) print $x . PHP_EOL;' < paths_to_keep.txt | while read path_to_keep; do
  if [ -n "`git status -s public_html/$path_to_keep`" ]; then
    echo "Error: There seem to be some local uncommitted changes to custom code which would get lost during rebuild. Aborting so that this can be taken care of."
    exit 1
  fi
done

if [ -e old_public_html ]; then
  echo "Error: 'old_public_html' exists already. It seems that a previous run of $0 did not finish properly. Manual cleanup required to prevent data loss."
  exit 1
fi

mv public_html old_public_html

drush make --yes --working-copy --no-gitinfofile --concurrency=10 bceln.make public_html

LAST_RETURN_VALUE=$?
if [ $LAST_RETURN_VALUE -ne 0 ]; then
  echo "Error: There was a problem with drush make. Manual cleanup required to prevent data loss."
  exit 1
fi

# Apply project-specific patches.
if [ -x ./copy_and_patch_locally.sh ]; then
  ./copy_and_patch_locally.sh
  LAST_RETURN_VALUE=$?
  if [ $LAST_RETURN_VALUE -ne 0 ]; then
    echo "Error: There was a problem with local patches."
    exit 1
  fi
fi

# Read paths_to_keep.txt and get rid of all comments and empty lines
php --process-code '$x = trim(preg_replace("/\s*#.*\$/", "", $argn)); if ($x) print $x . PHP_EOL;' < paths_to_keep.txt | while read path_to_keep; do
  git checkout -- public_html/$path_to_keep
  LAST_RETURN_VALUE=$?
  if [ $LAST_RETURN_VALUE -ne 0 ]; then
    echo "Error: There was a problem re-instating '$path_to_keep' via git."
    exit 1
  fi
done

cd $BASEDIR/public_html/sites/all/libraries/league_csv
composer install --no-dev
LAST_RETURN_VALUE=$?
if [ $LAST_RETURN_VALUE -ne 0 ]; then
  echo "Error: There was a problem running 'composer install' for league_csv library."
  exit 1
fi
cd $BASEDIR

exit

ln -s public_html/sites/default/files
mv old_public_html/sites/default/files public_html/sites/default/files

LAST_RETURN_VALUE=$?
if [ $LAST_RETURN_VALUE -ne 0 ]; then
  echo "Error: There was a problem with moving 'old_public_html/sites/default/files' to 'public_html/sites/default/files'. Manual cleanup required to prevent data loss."
  exit 1
fi

mv old_public_html/sites/default/settings.php public_html/sites/default/settings.php

LAST_RETURN_VALUE=$?
if [ $LAST_RETURN_VALUE -ne 0 ]; then
  echo "Error: There was a problem with moving 'old_public_html/sites/default/settings.php' to 'public_html/sites/default/settings.php'. Manual cleanup required to prevent data loss."
  exit 1
fi

# Last double-check before deleting old_public_html.
if [ -d old_public_html/sites/default/files ]; then
  echo "Error: 'old_public_html/sites/default/files' still exists and is a directory, not a symlink. It seems that it could not get moved to the proper destination. Manual cleanup required to prevent data loss."
  exit 1
fi

# Last double-check before deleting old_public_html.
if [ -f old_public_html/sites/default/settings.php ]; then
  echo "Error: 'old_public_html/sites/default/settings.php' still exists and is a regular file, not a symlink. It seems that it could not get moved to the proper destination. Manual cleanup required to prevent data loss."
  exit 1
fi

rm -rf old_public_html

cd public_html/sites/default
ln -s ../../../assets/files/ files
ln -s ../../../assets/settings.php settings.php
cd $BASEDIR

cd public_html

# sync DB to new code, but no auto-confirmation commandline switch ( "--yes" )
# in order to leave the choice to the user.
drush updb

# Go back where we came from.
cd $OLDDIR
