<?php

class Bceln_Migrate_Config {

  /**
   * @see https://docs.google.com/a/affinitybridge.com/spreadsheets/d/1IDxKXw-rsDrzt3-NOa4NnvnyhIlPbf6s55-JJEJPHxU/edit#gid=1131390086
   */
  // static public function getMandatoryUserMigrationsForCa($oldUid) {
  //   $userMap = [
  //     // om.ca uid => new uid
  //      1702 => 13, // OpenMedia
  //     12352 => 14, // Meghan Sali
  //         2 => 15, // Steve Anderson
  //        57 => 16, // Tyler Morgenstern
  //       399 => 17, // Reilly Yeo
  //      1557 => 18, // Lindsey Pinto
  //      1718 => 19, // Christopher Parsons
  //      1770 =>  7, // Vojtech Sedlak
  //      1815 => 20, // Shea Sinnott
  //      1811 => 21, // Glyn Lewis
  //      1856 => 22, // Dwayne Winseck
  //      1822 => 23, // Erin Brown-John
  //      2343 => 24, // Jes Simkin
  //      2390 => 25, // Tamir Israel
  //      2576 => 26, // Catherine Hart
  //      2353 => 27, // Connie Fournier
  //      2062 => 28, // Teresa Murphy
  //      3686 => 29, // Josh Tabish
  //      7180 => 30, // Chris Malmo
  //     10029 =>  3, // Ron Collins
  //      6831 => 31, // Noushin Khushrushahi
  //     12311 => 32, // Danielle Gannon
  //     12337 => 33, // Jason Hjalmarson
  //     12350 => 34, // Eva Prkachin
  //     12354 => 46, // Soledad Vega
  //   ];
  //   return isset($userMap[$oldUid]) ? $userMap[$oldUid] : static::getDefaultUid();
  // }

  /**
   * @see https://docs.google.com/a/affinitybridge.com/spreadsheets/d/1IDxKXw-rsDrzt3-NOa4NnvnyhIlPbf6s55-JJEJPHxU/edit#gid=1131390086
   */
  // static public function getMandatoryUserMigrationsForOrg($oldUid) {
  //   $userMap = [
  //     // om.org uid => new uid
  //     11 => 13, // OpenMedia
  //     77 => 14, // Meghan Sali
  //      9 => 15, // Steve Anderson
  //     85 => 17, // Reilly Yeo
  //      5 => 18, // Lindsey Pinto
  //     46 =>  7, // Vojtech Sedlak
  //      6 => 20, // Shea Sinnott
  //     73 => 21, // Glyn Lewis
  //     60 => 24, // Jes Simkin
  //     13 => 26, // Catherine Hart
  //     45 => 29, // Josh Tabish
  //     51 => 30, // Chris Malmo
  //     52 =>  3, // Ron Collins
  //     50 => 31, // Noushin Khushrushahi
  //     61 => 32, // Danielle Gannon
  //     63 => 33, // Jason Hjalmarson
  //     75 => 34, // Eva Prkachin
  //     97 => 46, // Soledad Vega
  //   ];
  //   return isset($userMap[$oldUid]) ? $userMap[$oldUid] : static::getDefaultUid();
  // }

  /**
   * The uid on the new system to be used as default node author.
   */
  static public function getDefaultUid() {
    return 1;
  }

  // static public function getRegionsByKeyword() {
  //   $default = [
  //     t('Obama') => ['usa', 'international'],
  //     t('net neutrality') => ['usa', 'international'],
  //     t('NSA') => ['usa', 'international'],
  //     t('National Security Agency') => ['usa', 'international'],
  //     t('Snowden') => ['usa', 'international'],
  //     t('Stingray') => ['usa', 'international'],
  //     t('FISA') => ['usa', 'international'],
  //     t('Patriot Act') => ['usa', 'international'],
  //     t('Freedom Act') => ['usa', 'international'],
  //     t('FBI') => ['usa', 'international'],
  //     t('Congress') => ['usa', 'international'],
  //     t('FCC') => ['usa', 'international'],
  //     t('Tom Wheeler') => ['usa', 'international'],
  //     t('Froman') => ['usa', 'international'],
  //     t('USTR') => ['usa', 'international'],
  //     t('U.S. Trade Representative') => ['usa', 'international'],
  //     t('Verizon') => ['usa', 'international'],
  //     t('Sprint') => ['usa', 'international'],
  //     t('T-Mobile') => ['usa', 'international'],
  //     t('Comcast') => ['usa', 'international'],
  //     t('Federal Communications Commission') => ['usa', 'international'],
  //     t('TWC') => ['usa', 'international'],
  //     t('Time Warner') => ['usa', 'international'],
  //     t('Hillary Clinton') => ['usa', 'international'],
  //     t('Wyden') => ['usa', 'international'],
  //     t('Senate') => ['usa', 'international'],
  //     t('Capitol Hill') => ['usa', 'international'],
  //     t('United States') => ['usa', 'international'],
  //     t('Donald Trump') => ['usa', 'international'],
  //     t('Jeb Bush') => ['usa', 'international'],
  //     t('Republican') => ['usa', 'international'],
  //     t('Democrat') => ['usa', 'international'],
  //     t('AT&T') => ['usa', 'international'],
  //     t('U.S.') => ['usa', 'international'],
  //     t('Washington') => ['usa', 'international'],
  //     t('D.C.') => ['usa', 'international'],
  //     t('Silicon Valley') => ['usa', 'international'],
  //     t('Google') => ['usa', 'international'],
  //     t('Apple') => ['usa', 'international'],
  //     t('Microsoft') => ['usa', 'international'],
  //     t('XKeyscore') => ['usa', 'international'],
  //     t('Facebook') => ['usa', 'international'],
  //     t('Twitter') => ['usa', 'international'],
  //     t('Prism') => ['usa', 'international'],
  //     t('Patriot Act') => ['usa', 'international'],
  //   ];
  //   return variable_get('migrate_regions_by_keyword', $default);
  // }

  // static public function getRegionTid($regionMachineName) {
  //   $regionMap = [
  //     'canada' => 29,
  //     'international' => 30,
  //     'usa' => 28,
  //   ];
  //   return isset($regionMap[$regionMachineName]) ? $regionMap[$regionMachineName] : NULL;
  // }

  /**
   * @see https://docs.google.com/a/affinitybridge.com/spreadsheets/d/1IDxKXw-rsDrzt3-NOa4NnvnyhIlPbf6s55-JJEJPHxU/edit#gid=0
   */
  // static public function getTermMappingForCa($oldTid) {
  //   $termMap = [
  //     151 => [ // Action Plan
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [33], // internet_choice_affordability
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     154 => [ // Affordability
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [33], // internet_choice_affordability
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     150 => [ // Cell Phones
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [31], // wireless
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     149 => [ // Copyright
  //       'pillars' => [5], // free_expression
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [36], // copyright
  //       'privacy' => [],
  //     ],
  // 
  //     173 => [ // Trans-Pacific Partnership (TPP)
  //       'pillars' => [5], // free_expression
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [35], // tpp
  //       'privacy' => [],
  //     ],
  // 
  //     148 => [ // Online Spying
  //       'pillars' => [4], // privacy
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [41], // privacy_deficit
  //     ],
  // 
  //     152 => [ // Letter to Supporters
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     174 => [ // Weekly News Update
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     157 => [ // Vertical Integration
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     153 => [ // Make The Switch
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [31], // wireless
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     64 => [ // Front Page
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     19 => [ // Media News Post
  //       'pillars' => [],
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     65 => [ // Policy
  //       'pillars' => [],
  //       'general' => [20, 22], // crowdsourcing, our_vision
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     170 => [ // Intern Chronicles
  //       'pillars' => [],
  //       'general' => [20], // crowdsourcing
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     135 => [ // Making Traffic Public
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     5 => [ // Press release
  //       'pillars' => [],
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     6 => [ // Openmedia.ca in the news
  //       'pillars' => [],
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     140 => [ // SOS Media
  //       'pillars' => [4], // privacy
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     63 => [ // Campaign
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     60 => [ // Net Neutrality
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [32], // net_neutrality
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     'DEFAULT' => [
  //       'pillars' => [],
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  //   ];
  //   return isset($termMap[$oldTid]) ? $termMap[$oldTid] : $termMap['DEFAULT'];
  // }

  /**
   * @see https://docs.google.com/a/affinitybridge.com/spreadsheets/d/1IDxKXw-rsDrzt3-NOa4NnvnyhIlPbf6s55-JJEJPHxU/edit#gid=0
   */
  // static public function getTermMappingForOrg($oldTid) {
  //   $termMap = [
  //     3 => [ // Access
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     1 => [ // Affordability
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [33], // internet_choice_affordability
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     4 => [ // Choice
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [33], // internet_choice_affordability
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     5 => [ // Diversity
  //       'pillars' => [5], // free_expression
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [37], // sharing_collaborating
  //       'privacy' => [],
  //     ],
  // 
  //     7 => [ // Freedom of Expression
  //       'pillars' => [5], // free_expression
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     6 => [ // Innovation
  //       'pillars' => [6], // access
  //       'general' => [],
  //       'access' => [34], // innovation
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     9 => [ // Letter to Supporters
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     8 => [ // Open Governance
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     2 => [ // Privacy
  //       'pillars' => [4], // privacy
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     10 => [ // Video Update
  //       'pillars' => [],
  //       'general' => [21], // free_open_internet
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  // 
  //     'DEFAULT' => [
  //       'pillars' => [],
  //       'general' => [],
  //       'access' => [],
  //       'free_expression' => [],
  //       'privacy' => [],
  //     ],
  //   ];
  //   return isset($termMap[$oldTid]) ? $termMap[$oldTid] : $termMap['DEFAULT'];
  // }

  // static public function getTextFormatMappingForCa($oldTextFormatId) {
  //   /*
  //   available destination formats:
  // 
  //   full_html,Full HTML
  //   php_code,PHP code
  //   plain_text,Plain text
  //   variable_text_size,Variable text size
  //   */
  //   $formatMap = [
  //     1 => 'full_html',          // Filtered HTML   ---> Full HTML
  //     2 => 'php_code',           // PHP code        ---> PHP code
  //     3 => 'full_html',          // Full HTML       ---> Full HTML
  //     4 => 'full_html',          // Pure HTML       ---> Full HTML
  //     5 => 'full_html',          // Language Filter ---> Full HTML
  //     6 => 'full_html',          // Escaped HTML    ---> Full HTML
  //     'DEFAULT' => 'plain_text', // unknown         ---> Plain text
  //   ];
  //   return isset($formatMap[$oldTextFormatId]) ? $formatMap[$oldTextFormatId] : $formatMap['DEFAULT'];
  // }

  // static public function getTextFormatMappingForOrg($oldTextFormatName) {
  //   /*
  //   available destination formats:
  // 
  //   full_html,Full HTML
  //   php_code,PHP code
  //   plain_text,Plain text
  //   variable_text_size,Variable text size
  //   */
  //   $formatMap = [
  //     'ds_code' => 'plain_text',      // Display Suite code ---> Plain text
  //     'filtered_html' => 'full_html', // Filtered HTML      ---> Full HTML
  //     'full_html' => 'full_html',     // Full HTML          ---> Full HTML
  //     'php_code' => 'php_code',       // PHP code           ---> PHP code
  //     'plain_text' => 'plain_text',   // Plain text         ---> Plain text
  //     'raw_html' => 'full_html',      // Raw HTML           ---> Full HTML
  //     'DEFAULT' => 'plain_text',      // unknown            ---> Plain text
  //   ];
  //   return isset($formatMap[$oldTextFormatName]) ? $formatMap[$oldTextFormatName] : $formatMap['DEFAULT'];
  // }
}
