<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2010 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: MAZZONI Vincent
// Purpose of file: management of communication with agents
// ----------------------------------------------------------------------
/**
 * The datas are XML encoded and compressed with Zlib.
 * XML rules :
 * - XML tags in uppercase
 **/

if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

require_once GLPI_ROOT.'/plugins/fusinvsnmp/inc/communicationsnmp.class.php';

/**
 * Class to communicate with agents using XML
 **/
class PluginFusinvdeployCommunicationOcsdeploy extends PluginFusinvsnmpCommunicationSNMP {
//   private $sxml, $deviceId, $ptd, $type='', $logFile;


   /**
    * Import data
    *
    *@param $p_DEVICEID XML code to import
    *@param $p_CONTENT XML code to import
    *@return "" (import ok) / error string (import ko)
    **/
   function import($p_DEVICEID, $p_CONTENT) {
      global $LANG;

      $PluginFusioninventoryTaskjobstatus = new PluginFusioninventoryTaskjobstatus;
      $PluginFusioninventoryAgent = new PluginFusioninventoryAgent;

      PluginFusioninventoryCommunication::addLog(
              'Function PluginFusinvdeployCommunicationOcsdeploy->import().');
      $this->setXML($p_CONTENT);
      $errors = '';

      if (isset($p_CONTENT->ERR)) {
         $errors = $p_CONTENT->ERR;
      }

      // Suivant les erreurs
         // get JOB id with package ID ($p_CONTENT->ID) and agent id
      $agent = $PluginFusioninventoryAgent->InfosByKey($p_CONTENT->DEVICEID);
      

      // Update taskjobstatus (state = 3 : finish); 
      //$PluginFusioninventoryTaskjobstatus->changeStatusFinish($taskjobs_id, $items_id, $itemtype, 0, $p_CONTENT->ERR, 1);


      return $errors;
   }
}

?>