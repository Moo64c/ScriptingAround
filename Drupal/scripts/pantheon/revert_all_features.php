<?php
/**
 * Created by Nader Safadi.
 * Company: gizra
 * Date: 04/04/2016
 * Time: 4:17 PM
 */

//Revert all features
echo "Reverting all features...\n";
passthru('drush fra -y');
echo "Reverting complete.\n";
//Clear all cache
echo "Clearing cache.\n";
passthru('drush cc all');
echo "Clearing cache complete.\n";
