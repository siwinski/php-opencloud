<?php
/**
 * Copyright 2012-2014 Rackspace US, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

//
// Pre-requisites:
// * Prior to running this script, you must setup the following environment variables:
//   * OS_AUTH_URL: Your OpenStack Cloud Authentication URL,
//   * OS_USERNAME: Your OpenStack Cloud Account Username,
//   * OS_PASSWORD:  Your OpenStack Cloud Account Password, and
//   * OS_REGION_NAME: The OpenStack Cloud region you want to use
//

require __DIR__ . '/../../vendor/autoload.php';
use OpenCloud\OpenStack;

// 1. Instantiate an OpenStack client.
$client = new OpenStack(getenv('OS_AUTH_URL'), array(
    'username' => getenv('OS_USERNAME'),
    'password' => getenv('OS_PASSWORD')
));

// 2. Obtain an Orchestration service object from the client.
$region = getenv('OS_REGION_NAME');
$orchestrationService = $client->orchestrationService(null, $region);

// 3. Create a stack.
$stack = $orchestrationService->createStack(array(
    'name'         => 'simple-lamp-setup',
    'templateUrl'  => 'https://raw.githubusercontent.com/rackspace-orchestration-templates/lamp/master/lamp.yaml',
    'parameters'   => array(
        'server_hostname' => 'web01',
        'image'           => 'Ubuntu 14.04 LTS (Trusty Tahr) (PVHVM)'
    ),
    'timeoutMins'  => 5
));
/** @var $stack OpenCloud\Orchestration\Resource\Stack **/
