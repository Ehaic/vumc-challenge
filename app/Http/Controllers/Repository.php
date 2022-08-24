<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Repository extends Controller
{
    //Display all repo's
    public function index() {
        $repositories = \App\Models\Repository::orderBy('stars', 'desc')->get(['projectName', 'id', 'stars']);
        return view('index')->with('repositories', $repositories);
    }

    //Get Repo Details from ID
    public function getRepoDetails($id) {
        $repository = \App\Models\Repository::find($id);
        $success = !is_null($repository);
       return [
           'success' => $success,
           $repository
       ];
    }

    //Update the repositories in the database from the GitHub API Gets top 100 starred Repositories.
    public function updateRepositories() {
        //Search API Repositories endpoint.
        //If I was doing more than this single search I'd write a class for building github api calls
        // or just use a composer package
        $githubApi = Http::get('https://api.github.com/search/repositories',
        [
            'q' => 'language:php', //PHP language tag
            'sort' => 'stars', //Sort results by number of stars,
            'order' => 'desc', //highest to lowest
            'per_page' => '100', //100 results per page
            'page' => '1' //first page
        ]);
        $searchResults = json_decode($githubApi->body());
        $success = count($searchResults->items) > 0;
        if ($success) {
            //Truncate the table, we only store 100 results.
            DB::table('repositories')->truncate();
            //foreach search result
            $bulkData = array();
            foreach ($searchResults->items as $repository) {
                //Map API Data to relevant Fields
                $repoInfo  = [
                    'id' => $repository->id,
                    'projectName' => $repository->name,
                    'URL' => $repository->html_url,
                    'repositoryCreatedAt' => \Carbon\Carbon::parse($repository->created_at),
                    'repositoryLastPush' => \Carbon\Carbon::parse($repository->pushed_at),
                    'description' => empty($repository->description) ? 'No Description' : $repository->description,
                    'stars' => $repository->stargazers_count
                ];
                $bulkData[] = $repoInfo;
            }
            //Bulk insert all data.
            \App\Models\Repository::insert($bulkData);
        }
        return ["success" => $success];
    }


}
