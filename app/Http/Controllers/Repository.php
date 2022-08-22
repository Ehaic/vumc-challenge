<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Repository extends Controller
{
    public function index() {
        $repositories = \App\Models\Repository::orderBy('stars', 'desc')->get();
        return view('index')->with('repositories', $repositories);
    }

    //Update the repositories in the database from the GitHub API Gets top 100 starred Repositories.
    public function updateRepositories() {
        $githubApi = Http::get('https://api.github.com/search/repositories',
        [
            'q' => 'language:php', //Repositories with PHP language tag
            'sort' => 'stars', //Sort results by number of stars,
            'order' => 'desc', //highest to lowest
            'per_page' => '100', //100 results per page
            'page' => '1' //first page
        ]);
        $searchResults = json_decode($githubApi->body());
        //foreach search result
        foreach ($searchResults->items as $repository) {
            //make a new model, or update if exists
            $localRepository = \App\Models\Repository::updateOrCreate([
                'id' => $repository->id
            ], [
                'id' => $repository->id,
                'projectName' => $repository->name,
                'URL' => $repository->html_url,
                'repositoryCreatedAt' => \Carbon\Carbon::parse($repository->created_at),
                'repositoryLastPush' => \Carbon\Carbon::parse($repository->pushed_at),
                'description' => empty($repository->description) ? 'No Description' : $repository->description,
                'stars' => $repository->stargazers_count
            ]);
        }
        return "DONE";
    }
}
