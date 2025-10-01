<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scan;
use App\Models\Vulnerability;
use App\Models\Project;

class ScanController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->json()->all();

            // pastikan struktur JSON sesuai
            $projectData = $data['project'] ?? null;
            if (!$projectData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Project data is required'
                ], 422);
            }

            // Simpan project
            $project = Project::firstOrCreate(
                ['name' => $projectData['name']],
                ['repo_url' => $projectData['repo_url']]
            );

            // Simpan scan
            $scan = Scan::create([
                'project_id' => $project->id,
                'scan_date' => $data['scan_date'],
                'raw_result' => json_encode($data['raw_result']),
            ]);

            // Simpan semua vulnerabilities
            $vulnerabilities = $data['vulnerabilities'] ?? [];
            foreach ($vulnerabilities as $vuln) {
                Vulnerability::create([
                    'scan_id' => $scan->id,
                    'project_id' => $project->id,
                    'cve_id' => $vuln['cve_id'] ?? null,
                    'package' => $vuln['package'] ?? null,
                    'installed_version' => $vuln['installed_version'] ?? null,
                    'fixed_version' => $vuln['fixed_version'] ?? null,
                    'severity' => $vuln['severity'] ?? null,
                    'title' => $vuln['title'] ?? null,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Scan data saved',
                'data' => $scan
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save scan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}