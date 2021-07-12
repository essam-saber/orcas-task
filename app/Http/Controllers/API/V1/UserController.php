<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Paginator\UserPaginator;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userService;
    private $userPaginator;

    public function __construct(UserService $userService, UserPaginator $userPaginator)
    {
        $this->userService = $userService;
        $this->userPaginator = $userPaginator;
    }

    public function index(Request $request)
    {
        $take = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        return $this->userService->getAllUsers($take, $page);
    }

    public function searchUsers(Request $request)
    {
        return $this->userService->searchUsers($request->keyword);
    }
}
