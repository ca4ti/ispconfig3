<?php
/*
Copyright (c) 2005, Till Brehm, projektfarm Gmbh
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice,
      this list of conditions and the following disclaimer in the documentation
      and/or other materials provided with the distribution.
    * Neither the name of ISPConfig nor the names of its contributors
      may be used to endorse or promote products derived from this software without
      specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/


/******************************************
* Begin Form configuration
******************************************/

$tform_def_file = "form/mail_whitelist.tform.php";

/******************************************
* End Form configuration
******************************************/

require_once '../../lib/config.inc.php';
require_once '../../lib/app.inc.php';

//* Check permissions for module
$app->auth->check_module_permissions('mail');

// Loading classes
$app->uses('tpl,tform,tform_actions');
$app->load('tform_actions');

class page_action extends tform_actions {

	protected $client_allowed_types = array( 'recipient', 'sender' );

	function onBeforeUpdate() {
		global $app, $conf;

		//* Check if the server has been changed
		$rec = $app->db->queryOneRecord("SELECT server_id from mail_access WHERE access_id = ?", $this->id);
		if($rec['server_id'] != $this->dataRecord["server_id"]) {
			//* Add a error message and switch back to old server
			$app->tform->errorMessage .= $app->lng('The Server can not be changed.');
			$this->dataRecord["server_id"] = $rec['server_id'];
		}
		unset($rec);
	}

	function onSubmit() {
		global $app, $conf;

		// Non-admin checks
		if($_SESSION["s"]["user"]["typ"] != 'admin') {
			// Non-admin can only use type 'sender' or 'recipient' and address must belong to the client's domains
			if(! in_array($this->dataRecord["type"], $this->client_allowed_types)) {
				$app->tform->errorMessage .= $app->lng('Whitelist type requires admin permissions');
			}
			// address must be valid email
			if(! filter_var( $this->dataRecord["source"], FILTER_VALIDATE_EMAIL )) {
				$app->tform->errorMessage .= $app->lng('Invalid address: must be a valid email address');
			}
			$tmp = explode('@', $this->dataRecord["source"]);
			$domain = trim( array_pop($tmp) );
			$AUTHSQL = $app->tform->getAuthSQL('r');
			$rec = $app->db->queryOneRecord("SELECT domain_id from mail_domain WHERE ${AUTHSQL} AND domain = ?", $domain);
			// address must belong to the client's domains
			if(! (is_array($rec) && isset($rec['domain_id']) && is_numeric($rec['domain_id']))) {
				$app->tform->errorMessage .= $app->lng('Invalid address: you have no permission for this domain.');
			}
			unset($rec);
		}

		if(substr($this->dataRecord['source'], 0, 1) === '@') $this->dataRecord['source'] = substr($this->dataRecord['source'], 1);

		parent::onSubmit();
	}

}

$app->tform_actions = new page_action;
$app->tform_actions->onLoad();


?>
