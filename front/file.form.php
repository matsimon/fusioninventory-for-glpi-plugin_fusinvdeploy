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

define('GLPI_ROOT', '../../..');

include (GLPI_ROOT . "/inc/includes.php");

commonHeader($LANG['plugin_fusinvdeploy']["title"][0],$_SERVER["PHP_SELF"],"plugins","fusioninventory","files");

$PluginFusinvdeployFile = new PluginFusinvdeployFile;

//PluginFusioninventoryProfile::checkRight("fusinvdeploy", "files","r");

PluginFusioninventoryMenu::displayMenu("mini");

if (isset ($_POST["add"])) {
//   PluginFusioninventoryProfile::checkRight("fusinvdeploy", "files","w");
   if (isset($_FILES['uploadfile']['tmp_name'])) {
      $sum = sha1_file($_FILES['uploadfile']['tmp_name']);
      copy($_FILES['uploadfile']['tmp_name'], GLPI_PLUGIN_DOC_DIR."/fusinvdeploy/files/".$sum);
      if ($_POST['filename'] == "") {
         $_POST['filename'] = $_FILES['uploadfile']['name'];
      }
      $_POST['sha1sum'] = $sum;
   }

   $PluginFusinvdeployFile->add($_POST);
   glpi_header($_SERVER['HTTP_REFERER']);
} else if (isset ($_POST["update"])) {
//   PluginFusioninventoryProfile::checkRight("fusinvdeploy", "files","w");
   if (isset($_POST['items_id'])) {
      if (($_POST['items_id'] != "0") AND ($_POST['items_id'] != "")) {
         $_POST['itemtype'] = '1';
      }
   }
   $PluginFusinvdeployFile->update($_POST);
   glpi_header($_SERVER['HTTP_REFERER']);
} else if (isset ($_POST["delete"])) {
//   PluginFusioninventoryProfile::checkRight("fusinvdeploy", "files","w");
   $PluginFusinvdeployFile->getFromDB($_POST['id']);
   unlink(GLPI_PLUGIN_DOC_DIR."/fusinvdeploy/files/".$PluginFusinvdeployFile->fields['sha1sum']);

   $PluginFusinvdeployFile->delete($_POST);
   glpi_header("file.php");
}


if (isset($_GET["id"])) {
   $PluginFusinvdeployFile->showForm($_GET["id"]);
} else {
   $PluginFusinvdeployFile->showForm("");
}

commonFooter();

?>