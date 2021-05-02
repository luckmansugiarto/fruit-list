<?php

namespace App\Http\Controllers;

use App\Services\Database\FruitRepository;
use App\Services\DataStructure\FruitDataStructureService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DefaultController extends Controller
{
    public FruitRepository $repository;

    public function __construct(FruitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(FruitDataStructureService $treeModel)
    {
        $fruits = $treeModel->constructHierarchy($this->repository->findAll());

        return Inertia::render('Index/Index', ['fruits' => $fruits]);
    }

    public function post(Request $request)
    {
        if ($request->has('data'))
        {
            $result = $this->repository->update($request->input('data'));
        }

        return redirect()->route('main');
    }
}
