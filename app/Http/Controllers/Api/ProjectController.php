<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller {
    public function index() {
        try {
            $projects = Project::withCount('vulnerabilities')->get();
            return response()->json([
                'status' => 'success',
                'data' => $projects
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch projects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function vulnerabilities($id, Request $request) {
        try {
            $severity = $request->query('severity');
            $project = Project::findOrFail($id);
            $query = $project->vulnerabilities()->with('scan');
            
            if ($severity) {
                $query->where('severity', strtoupper($severity));
            }
            
            $vulnerabilities = $query->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $vulnerabilities
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch vulnerabilities',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
