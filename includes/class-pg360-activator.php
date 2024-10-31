<?php
/**
 * Fired during plugin activation
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pg360
 * @subpackage Pg360/includes
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function pg360_activate() {
		
		/**
		 * Define / upgrade Database Version:
		 * Database current version 1.5.0
		 */
		global $pg360_db_version;
		$pg360_db_version="1.5.0";
		$installed_db_version = get_option( "pg360_db_version" );
		
		global $wpdb;
		$pg360_table1Name = $wpdb->prefix .'pg360_project_details';
		$pg360_table2Name = $wpdb->prefix .'pg360_images_details';
		/**
		 * if Newly install the plugin
		 * then complete table creation
		 */
		if (get_option( "pg360_db_version")==null||get_option( "pg360_db_version")==''){
			add_option( 'pg360_db_version', $pg360_db_version );
		}
		if($installed_db_version !==$pg360_db_version){
			// Update Database Version
			update_option( 'pg360_db_version', $pg360_db_version );
			
			//check if table 1 exist
			if($wpdb->get_var("SHOW TABLES LIKE '$pg360_table1Name'") !== $pg360_table1Name) {
				
				$pg360_addNew_sql="CREATE TABLE $pg360_table1Name (
					`ID` int(11) NOT NULL AUTO_INCREMENT,
					`ProjectName` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
					`Clone` bit(1) NOT NULL,
					`ShortCode` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
					`CreationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					`ProjectWidth` mediumint(8) NOT NULL,
					`ProjectHeight` mediumint(8) NOT NULL,
					`NoPerLayer` tinyint(3) unsigned NOT NULL,
					`NoOfLayer` tinyint(3) unsigned NOT NULL,
					`CursorShape` enum('hand','','default','none','alias','col-resize','row-resize') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
					`ColorFilter` enum('default','BW','PGfilter1','PGfilter2','PGfilter3','PGfilter4','PGfilter5','PGfilter6') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
					`DisplayControlBtn` bit(1) NOT NULL,
					`Speed` tinyint(3) unsigned NOT NULL,
					`Preloader` tinyint(3) unsigned NOT NULL,
					`Interactive` bit(1) NOT NULL,
					`Orientable` bit(1) NOT NULL,
					`ClickFree` bit(1) NOT NULL,
					`CW` bit(1) NOT NULL,
					`Shy` bit(1) NOT NULL,
					`wheelable` bit(1) NOT NULL,
					`360Type` enum('loops','non-loop') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,

					PRIMARY KEY (`ID`),
					UNIQUE KEY `projectName` (`projectName`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";
				
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );							
				dbDelta( $pg360_addNew_sql );			
			}
			//Create DB Table to store images URI W.R.T Project table  :
			if($wpdb->get_var("SHOW TABLES LIKE '$pg360_table2Name'") !== $pg360_table2Name) {
							
				$pg360_images_sql="CREATE TABLE $pg360_table2Name (
					`ImageID` int(11) NOT NULL AUTO_INCREMENT,
					`ProjectID` int(11) NOT NULL,
					`ImageURL` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
					`Width` mediumint(8) NOT NULL,
					`Height` mediumint(8) NOT NULL,
					`UploadTime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (`ImageID`),
					KEY `pg360Relations` (`projectID`),
					CONSTRAINT `pg360Relations` 
					FOREIGN KEY (`projectID`) REFERENCES $pg360_table1Name (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=UTF8";
				
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );							
				dbDelta( $pg360_images_sql );		
			}

		}
	}
}