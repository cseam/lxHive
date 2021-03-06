<?php

/*
 * This file is part of lxHive LRS - http://lxhive.org/
 *
 * Copyright (C) 2017 Brightcookie Pty Ltd
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with lxHive. If not, see <http://www.gnu.org/licenses/>.
 *
 * For authorship information, please view the AUTHORS
 * file that was distributed with this source code.
 */

namespace API\Controller\V10\Activities;

use API\Controller;
use API\Service\ActivityState as ActivityStateService;
use API\View\V10\ActivityState as ActivityStateView;

class State extends Controller
{
    /**
     * @var \API\Service\ActivityState
     */
    private $activityStateService;

    /**
     * Get activity service.
     */
    public function init()
    {
        $this->activityStateService = new ActivityStateService($this->getContainer());
    }

    /**
     * Handle the Statement GET request.
     */
    public function get()
    {
        // Check authentication
        $this->getContainer()->get('auth')->requirePermission('state');

        // TODO 0.11.x request validation

        $documentResult = $this->activityStateService->activityStateGet();

        // Render them
        $view = new ActivityStateView($this->getResponse(), $this->getContainer());

        if ($documentResult->getIsSingle()) {
            $view = $view->renderGetSingle($documentResult);
            return $this->response(Controller::STATUS_OK, $view);
        } else {
            $view = $view->renderGet($documentResult);
            return $this->jsonResponse(Controller::STATUS_OK, $view);
        }
    }

    public function put()
    {
        // Check authentication
        $this->getContainer()->get('auth')->requirePermission('state');

        // TODO 0.11.x request validation

        // Save the state
        $documentResult = $this->activityStateService->activityStatePut();

        //Always an empty response, unless there was an Exception
        return $this->response(Controller::STATUS_NO_CONTENT);
    }

    public function post()
    {
        // Check authentication
        $this->getContainer()->get('auth')->requirePermission('state');

        // Do the validation - TODO!!!
        //$this->statementValidator->validateRequest($request);
        //$this->statementValidator->validatePutRequest($request);

        // Save the state
        $documentResult = $this->activityStateService->activityStatePost();

        //Always an empty response, unless there was an Exception
        return $this->response(Controller::STATUS_NO_CONTENT);
    }

    public function delete()
    {
        // Check authentication
        $this->getContainer()->get('auth')->requirePermission('state');

        // TODO 0.11.x request validation

        // Save the state
        $documentResult = $this->activityStateService->activityStateDelete();

        //Always an empty response, unless there was an Exception
        return $this->response(Controller::STATUS_NO_CONTENT);
    }

    public function options()
    {
        //Handle options request
        $this->setResponse($this->getResponse()->withHeader('Allow', 'POST,PUT,GET,DELETE'));
        return $this->response(Controller::STATUS_OK);
    }

    /**
     * Gets the value of activityStateService.
     *
     * @return \API\Service\ActivityState
     */
    public function getActivityStateService()
    {
        return $this->activityStateService;
    }
}
