<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;
use Base\Request;
use Base\BaseController;
use Intervention\Image\ImageManagerStatic as Image;

class TasksController extends BaseController
{
    protected $request;
    protected $userId;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $tasks = new Task();
        $limit = 3;

        $page = $this->request->get('page');
        $orderBy = $this->request->get('order_by');
        $orderDir = $this->request->get('order_dir');

        $page = ((int)$page > 0) ? $page : 1;
        $pagesCount = ceil(Task::count() / $limit);
        $page = min($pagesCount, $page);
        $skip = ($page - 1) * $limit;
        $orderBy = (in_array($orderBy, ['username', 'email', 'done'])) ? $orderBy : 'username';
        $orderDir = (in_array($orderDir, ['asc', 'desc'])) ? $orderDir : 'asc';

        $links = $this->getLinks($orderBy, $orderDir, $page, $pagesCount);

        $tasks = $tasks->orderBy($orderBy, $orderDir)->skip($skip)->take($limit)->get();

        $this->view('tasksList', [
            'tasks' => $tasks,
            'links' => $links,
            'page' => $page,
            'pagesCount' => $pagesCount,
        ]);
    }

    public function getLinks($orderBy, $orderDir, $page, $pagesCount)
    {
        $links = [];
        foreach (['username', 'email', 'done'] as $key) {
            $icon = null;
            $params = ['order_by' => $key];
            if ($key == $orderBy) {
                $icon = 'glyphicon-menu-down';
                if ($orderDir != 'desc') {
                    $params['order_dir'] = 'desc';
                    $icon = 'glyphicon-menu-up';
                }
            }
            if ($page > 1) $params['page'] = $page;
            $links[$key] = ['url' => '/?' . http_build_query($params), 'icon' => $icon];
        }

        foreach (['prev', 'next'] as $key) {
            $params = [];
            if ($this->request->get('order_by')) {
                $params['order_by'] = $this->request->get('order_by');
            }
            if ($this->request->get('order_dir')) {
                $params['order_dir'] = $this->request->get('order_dir');
            }
            $active = false;
            if ($key == 'prev') {
                if ($page > 1) {
                    $params['page'] = $page - 1;
                    $active = true;
                }
            } else {
                if ($page < $pagesCount) {
                    $params['page'] = $page + 1;
                    $active = true;
                }
            }
            $links[$key] = ['url' => '/?' . http_build_query($params), 'active' => $active];
        }

        return $links;
    }

    public function create()
    {
        $this->view('tasksForm');
    }

    public function imagePrepare($key)
    {
        $imageFile = $this->request->getImageInfo($key);
        if (!$imageFile['valid']) {
            return null;
        }
        $fileName = 'image_' . time() . '.' . $imageFile['type'];
        $filePath = $this->request->documentRoot . '/assets/images/' . $fileName;
        $imageMoved = move_uploaded_file($imageFile['tmpName'], $filePath);
        if ($imageMoved) {
            $image = Image::make($filePath);
            if (($image->width() > 320) || ($image->height() > 240)) {
                $image->resize(320, 240, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
        }

        $path = '/assets/images/' . $fileName;
        return $path;
    }

    public function store()
    {
        $image = $this->imagePrepare('image');
        $fields = [
            'username' => $this->request->get('username'),
            'email' => $this->request->get('email'),
            'text' => $this->request->get('text'),
        ];
        if (!$fields['username'] || !$fields['email']) {
            $errors = 'Required fields: Username, Email.';
            $this->view('tasksForm', [
                'fields' => $fields,
                'errors' => $errors,
            ]);
        } else {
            Task::create([
                'username' => $this->request->get('username'),
                'email' => $this->request->get('email'),
                'text' => $this->request->get('text'),
                'image' => $image,
                'done' => 0,
            ]);
            return header('Location: /');
        }
    }

    public function edit($id)
    {
        if (is_null(User::getId())) {
            header("{$this->request->serverProtocol} 403 Forbidden");
            die;
        }
        $task = Task::where('id', $id)->first();
        if ($task) {
            $fields = [
                'id' => $task->id,
                'username' => $task->username,
                'email' => $task->email,
                'text' => $task->text,
                'image' => $task->image,
                'done' => $task->done,
            ];
            $this->view('tasksForm', [
                'fields' => $fields,
                'action' => 'edit',
            ]);
        } else {
            header("{$this->request->serverProtocol} 404 Not Found");
        }
    }

    public function update($id)
    {
        if (is_null(User::getId())) {
            header("{$this->request->serverProtocol} 403 Forbidden");
            die;
        }
        $task = Task::where('id', $id)->first();
        if ($task) {
            $task->update([
                'text' => $this->request->get('text'),
                'done' => ($this->request->get('done') == 1) ? 1 : 0,
            ]);
            return header('Location: /');
        } else {
            header("{$this->request->serverProtocol} 404 Not Found");
        }
    }
}
