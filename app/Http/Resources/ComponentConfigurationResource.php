<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use OpenDialogAi\ActionEngine\Service\ActionComponentServiceInterface;
use OpenDialogAi\Core\Components\Helper\ComponentHelper;
use OpenDialogAi\InterpreterEngine\Service\InterpreterComponentServiceInterface;
use OpenDialogAi\PlatformEngine\Services\PlatformComponentServiceInterface;

class ComponentConfigurationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $componentId = $this->component_id;
        $type = ComponentHelper::parseComponentId($componentId);

        $component = null;

        switch ($type) {
            case 'platform':
                $component = resolve(PlatformComponentServiceInterface::class)->get($componentId);
                break;
            case 'interpreter':
                $component = resolve(InterpreterComponentServiceInterface::class)->get($componentId);
                break;
            case 'action':
                $component = resolve(ActionComponentServiceInterface::class)->get($componentId);
                break;
        }

        /** @var array $hiddenFields */
        $hiddenFields = $component::getConfigurationClass()::getHiddenFields();

        $finalArray = parent::toArray($request);

        $finalArray['configuration'] = $this->filterHiddenFields($finalArray['configuration'], $hiddenFields);

        return $finalArray;
    }

    protected function filterHiddenFields($originalArray, $hiddenFields)
    {
        foreach ($hiddenFields as $field) {
            // The array is passes by reference into Array::forget,
            // so originalArray becomes updated
            Arr::forget($originalArray, $field);
        }

        return $originalArray;
    }
}
