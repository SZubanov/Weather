<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected string $templatePath = 'admin.';

    protected Service $service;
    protected BaseResource $resource;

    public function __construct(Service $service, BaseResource $resource = null)
    {
        $this->service = $service;
        $this->setResource($resource);
    }

    public function index()
    {
        $request = request();

        if ($request->ajax()) {
            return $this->service->getObjectsForTable($request->toArray());
        }

        return $this->getView(__FUNCTION__, $this->service->getDataForIndex());
    }

    public function create()
    {
        return $this->getView(__FUNCTION__, $this->service->getDataForCreate());
    }

    /**
     * Вернуть страницу
     * @param string $view - Путь до шаблона после $this->templatePath
     * @param array $params - Массив с данными для шаблона
     * @return View
     */
    protected function getView(string $view, array $params = []): View
    {
        $common = [
            'title' => $params['title'] ?? $this->getTitle(),
        ];

        return view($this->templatePath . $view)->with(array_merge($params, $common));
    }

    /**
     * Для всех страниц должен генерироваться тайтл из названия маршрута и составного ключа title
     *
     * @return string
     */
    protected function getTitle(): string
    {
        return __($this->getRouteName() . '.title');
    }

    /**
     * Вернуть название текущего маршрута
     * @return string
     */
    protected function getRouteName(): string
    {
        return \Request::route()->getName();
    }

    /**
     * Добавить ресурс
     *
     * @param BaseResource|null $resource
     */
    private function setResource(BaseResource $resource = null)
    {
        $this->resource = !is_null($resource) ? $resource : app(BaseResource::class);
    }

    /**
     * Вернуть ресурс
     *
     * @return BaseResource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
