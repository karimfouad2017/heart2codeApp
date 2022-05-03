<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimulationRequest;
use Illuminate\Http\JsonResponse;
use OpenDialogAi\ConversationEngine\Simulator\ConversationSimulator;
use OpenDialogAi\ConversationEngine\Util\SimulatorConversationalState;
use OpenDialogAi\Core\Conversation\Conversation;
use OpenDialogAi\Core\Conversation\Intent;
use OpenDialogAi\Core\Conversation\Scenario;
use OpenDialogAi\Core\Conversation\Scene;
use OpenDialogAi\Core\Conversation\Turn;

class ConversationSimulationController extends Controller
{
    public function simulate(SimulationRequest $request)
    {
        $conversationalState = (new SimulatorConversationalState($request->json('speaker'), $request->json('turn_status')))
            ->setScenarioId($request->json('scenario') ?? Scenario::UNDEFINED)
            ->setConversationId($request->json('conversation') ?? Conversation::UNDEFINED)
            ->setSceneId($request->json('scene') ?? Scene::UNDEFINED)
            ->setTurnId($request->json('turn') ?? Turn::UNDEFINED)
            ->setIntentId($request->json('intent') ?? Intent::UNDEFINED)
            ->setVirtualIntent($request->json('virtual_intent'));

        $response = ConversationSimulator::simulate($conversationalState);

        return new JsonResponse($response);
    }
}
