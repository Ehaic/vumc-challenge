<head>
    <title>Github PHP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-r from-pink-300 via-purple-300 to-indigo-400">
<div>
    <x-repo-detail-modal></x-repo-detail-modal>
<div class="w-3/4 lg:w-1/2 mx-auto rounded-md bg-slate-700 shadow-lg m-20 p-10 text-center content-center">
    <h1 class="text-3xl font-bold underline m-10 text-gray-200">Top 100 PHP Github Repositories Using PHP</h1>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <button id="updateButton" onclick="updateRepos()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
            Refresh Data
        </button>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Project Name
                </th>
                <th scope="col" class="py-3 px-6">
                    Stars
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($repositories as $repository)
                    <tr class="repoRow even:bg-white odd:bg-gray-100 border-b even:dark:bg-gray-900 dark:border-gray-700 hover:bg-slate-500" onclick="showDetailsRow({{ $repository->id }})">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $repository->projectName }}
                        </th>
                        <td class="py-4 px-6">
                            {{ $repository->stars }}
                        </td>
                    </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>


<script>
    //Get repo detail info, populate and show modal.
    function showDetailsRow(repoID) {
        $.get('/getRepoDetails/' + repoID, function (data) {
            if(data.success) {
                $('#detailProjectName').text("Project Name: " + data[0].projectName);
                $('#detailUrl').attr('href', data[0].URL);
                $('#detailUrl').text(data[0].URL);
                $('#detailDescription').text(data[0].description);
                $('#detailCreateDate').text("Project Created: " + data[0].repositoryCreatedAt);
                $('#detailPushDate').text("Last Push Seen: " + data[0].repositoryLastPush);
            }
            let modal = $('#repoDetailModal');
            $('#repoDetailModal').removeClass('hidden');
        });
    }

    //Hit update repo's endpoint, reload page.
    function updateRepos() {
        $('#updateButton').text("Loading...");
        $('#updateButton').prop('disabled', true);
        $.get('/updateRepos', function (data) {
            if(!data['success']) {
              alert("Issue Getting Repositories from Github");
            }
        }).fail(function () {
            alert("Issue Getting Repositories from Github");
        }).always(function () {
            location.reload();
        })
    }
</script>

<script type="module">
    //This function hides the modal
    $('#repoDetailModal').click(function () {
        $('#repoDetailModal').addClass('hidden');
    })
</script>
