<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     *
     * @return ResponseFactory|Response
     */
    public function index(): Response|ResponseFactory
    {
        $projects = Project::all();

        return response(
            [
                'projects' => ProjectResource::collection($projects),
                'message'  => 'Retrieved successfully',
            ]
        );
    }


    /**
     * Store a newly created project in storage.
     *
     * @param Request $request
     *
     * @return ResponseFactory|Response
     */
    public function store(Request $request): Response|ResponseFactory
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'name'         => 'required|max:255',
                'introduction' => 'required|max:255',
                'cost'         => 'required',
            ]
        );

        if ($validator->fails()) {
            return response(
                [
                    'error'   => $validator->errors(),
                    'message' => 'Fields are invalid',
                ]
            );
        }

        $project = Project::factory()->createOne($data);

        return response(
            [
                'project' => new ProjectResource($project),
                'message' => 'Created successfully',
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Display the specified project.
     *
     * @param Project $project
     *
     * @return ResponseFactory|Response
     */
    public function show(Project $project): Response|ResponseFactory
    {
        return response(
            [
                'project' => new ProjectResource($project),
                'message' => 'Retrieved successfully',
            ]
        );
    }


    /**
     * Update the specified project in storage.
     *
     * @param Request $request
     * @param Project $project
     *
     * @return ResponseFactory|Response
     */
    public function update(Request $request, Project $project): Response|ResponseFactory
    {
        $project->update($request->all());

        return response(
            [
                'project' => new ProjectResource($project),
                'message' => 'Updated successfully',
            ]
        );
    }


    /**
     * Remove the specified project from storage.
     *
     * @param Project $project
     *
     * @throws \Exception
     * @return ResponseFactory|Response
     */
    public function destroy(Project $project): Response|ResponseFactory
    {
        $project->delete();

        return response(
            [
                'message' => 'Deleted successfully',
            ]
        );
    }

}
