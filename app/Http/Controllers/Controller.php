<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Services\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected string $templatePath = 'admin.';

    protected Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @return View|JsonResponse
     */
    public function index()
    {
        $request = request();

        if ($request->ajax()) {
            return $this->service->getObjectsForTable($request->toArray());
        }

        return $this->getView(__FUNCTION__, $this->service->getDataForIndex());
    }

    public function create(): View
    {
        return $this->getView(__FUNCTION__, $this->service->getDataForCreate());
    }

    public function storeElement(array $request): RedirectResponse
    {
        $this->service->store($request);
        toastr()->success(__('answer.create'));
        return redirect()->route('users.index');
    }

    public function editElement(Model $model): View
    {
        return $this->getView('create', $this->service->getDataForEdit($model));
    }


    public function updateElement(array $request, Model $model): RedirectResponse
    {
        $this->service->update($request, $model);
        toastr()->success(__('answer.update'));
        return redirect()->back();
    }

    /**
     * Вернуть страницу
     * @param string $view - Путь до шаблона после $this->templatePath
     * @param array $params - Массив с данными для шаблона
     * @return Application|Factory|View
     */
    protected function getView(string $view, array $params = [])
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
}
