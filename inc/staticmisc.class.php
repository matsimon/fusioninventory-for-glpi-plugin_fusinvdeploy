<?php

/*
   ----------------------------------------------------------------------
   FusionInventory
   Copyright (C) 2003-2008 by the INDEPNET Development Team.

   http://www.fusioninventory.org/   http://forge.fusioninventory.org//
   ----------------------------------------------------------------------

   LICENSE

   This file is part of FusionInventory plugins.

   FusionInventory is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   FusionInventory is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with FusionInventory; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
   ------------------------------------------------------------------------
 */

// Original Author of file: David DURIEUX
// Purpose of file:
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginFusinvdeployStaticmisc {
   static function task_methods() {
      global $LANG;

      $a_tasks = array();
      $a_tasks[] = array('module'         => 'fusinvdeploy',
                         'method'         => 'ocsdeploy',
                         'selection_type' => 'devices',
                         'selection_type_name' => "devices");
      $a_tasks[] = array('module'         => 'fusinvdeploy',
                         'method'         => 'ocsdeploy',
                         'selection_type' => 'rules');
      $a_tasks[] = array('module'         => 'fusinvdeploy',
                         'method'         => 'ocsdeploy',
                         'selection_type' => 'devicegroups');
      return $a_tasks;
   }

   # Actions with itemtype autorized
   static function task_action_ocsdeploy() {
      $a_itemtype = array();
      $a_itemtype[] = 'PluginFusinvdeployPackage';
      $a_itemtype[] = 'Computer';

      return $a_itemtype;
   }

   # Selection type for actions
   static function task_selection_type_ocsdeploy($itemtype) {
      switch ($itemtype) {

         case 'PluginFusinvdeployPackage':
         case 'Computer';
            $selection_type = 'devices';
            break;

      }

      return $selection_type;
   }

   # Select arguments if exist
   static function task_argument_ocsdeploy($title) {
      global $LANG;
      
      //$a_list = $PluginFusinvdeployPackage->find();
      if ($title == '1') {
         echo $LANG['plugin_fusinvdeploy']["package"][7]."&nbsp;:";
      } else {
         $options = array();
         $options['entity'] = $_SESSION['glpiactive_entity'];
         $options['entity_sons'] = 1;
         $options['name'] = 'argument';
         Dropdown::show("PluginFusinvdeployPackage", $options);
      }
   }

   static function displayMenu() {
      global $LANG;

      $a_menu = array();
      if (PluginFusioninventoryProfile::haveRight("fusinvdeploy", "packages", "r")) {
         $a_menu[0]['name'] = $LANG['plugin_fusinvdeploy']["package"][6];
         $a_menu[0]['pic']  = GLPI_ROOT."/plugins/fusinvdeploy/pics/menu_package.png";
         $a_menu[0]['link'] = GLPI_ROOT."/plugins/fusinvdeploy/front/package.php";
      }

      $a_menu[1]['name'] = $LANG['plugin_fusinvdeploy']["files"][0];
      $a_menu[1]['pic']  = GLPI_ROOT."/plugins/fusinvdeploy/pics/menu_files.png";
      $a_menu[1]['link'] = GLPI_ROOT."/plugins/fusinvdeploy/front/file.php";

      if (PluginFusioninventoryProfile::haveRight("fusinvdeploy", "status", "r")) {
         $a_menu[2]['name'] = $LANG['plugin_fusinvdeploy']["deploystatus"][0];
         $a_menu[2]['pic']  = GLPI_ROOT."/plugins/fusinvdeploy/pics/menu_deploy_status.png";
         $a_menu[2]['link'] = GLPI_ROOT."/plugins/fusinvdeploy/front/deploystate.php";
      }

      return $a_menu;
   }


   static function profiles() {
      global $LANG;

      $a_profil = array();
      $a_profil[] = array('profil'  => 'packages',
                          'name'    => $LANG['plugin_fusinvdeploy']['profile'][2]);
      $a_profil[] = array('profil'  => 'status',
                          'name'    => $LANG['plugin_fusinvdeploy']['profile'][3]);

      return $a_profil;
   }

}

?>