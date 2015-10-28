#!/bin/bash
BASEDIR=`php -r "echo dirname(realpath('$0'));"`
OLDDIR=`pwd`

for PROJECTNAME in `find $BASEDIR/patches/* -maxdepth 1 -type d -exec basename "{}" ";"`;
do
  for PATCHNAME in `ls $BASEDIR/patches/$PROJECTNAME/*.patch`;
  do
    cd $BASEDIR/public_html/sites/all/modules/$PROJECTNAME
    echo Now patching project "$PROJECTNAME" with patch "`basename $PATCHNAME`":
    patch -p1 < $PATCHNAME
    LAST_RETURN_VALUE=$?
    if [ $LAST_RETURN_VALUE -ne 0 ]; then
      echo "Error: There was a problem with the local patch `basename $PATCHNAME` for project $PROJECTNAME"
      exit 1
    fi
  done
done
cd $BASEDIR

# Go back where we came from.
cd $OLDDIR
