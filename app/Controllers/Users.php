<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $data = [
            'title' => 'User Accounts',
            'users' => $userModel->findAll()
        ];

        return view('users/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'New User'
        ];

        return view('users/new', $data);
    }

    public function create()
    {
        $rules = [
            'username' => [
                'rules' => 'required|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'required'   => 'The username is required.',
                    'max_length' => 'The username cannot exceed 50 characters.',
                    'is_unique'  => 'That username is already being used.'
                ]
            ],
            'full_name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'The full name is required.',
                    'max_length' => 'The full name cannot exceed 100 characters.'
                ]
            ]
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $userModel = new UserModel();

        $userModel->insert([
            'username' => trim(
                (string) $this->request->getPost('username')
            ),
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            )
        ]);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'User account created successfully.');
    }

    public function edit(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User account not found.'
            );
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $user
        ];

        return view('users/edit', $data);
    }

    public function update(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User account not found.'
            );
        }

        $rules = [
            'username' => [
                'rules' => 'required|max_length[50]'
                    . '|is_unique[users.username,id,' . $id . ']',
                'errors' => [
                    'required'   => 'The username is required.',
                    'max_length' => 'The username cannot exceed 50 characters.',
                    'is_unique'  => 'That username is already being used.'
                ]
            ],
            'full_name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'The full name is required.',
                    'max_length' => 'The full name cannot exceed 100 characters.'
                ]
            ]
        ];

        $avatar = $this->request->getFile('avatar');

        if (
            $avatar !== null
            && $avatar->getError() !== UPLOAD_ERR_NO_FILE
        ) {
            $rules['avatar'] = [
                'rules' => [
                    'uploaded[avatar]',
                    'max_size[avatar,2048]',
                    'is_image[avatar]',
                    'mime_in[avatar,image/jpg,image/jpeg,image/png]'
                ],
                'errors' => [
                    'uploaded' => 'Please select an avatar image.',
                    'max_size' => 'The avatar must not be larger than 2 MB.',
                    'is_image' => 'The selected file must be an image.',
                    'mime_in'  => 'Only JPG and PNG images are allowed.'
                ]
            ];
        }

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $updateData = [
            'username' => trim(
                (string) $this->request->getPost('username')
            ),
            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            )
        ];

        if (
            $avatar !== null
            && $avatar->isValid()
            && ! $avatar->hasMoved()
        ) {
            $uploadPath = FCPATH . 'uploads/avatars';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $newName = $avatar->getRandomName();

            $destination = $uploadPath
                . DIRECTORY_SEPARATOR
                . $newName;

            service('image')
                ->withFile($avatar->getTempName())
                ->fit(300, 300, 'center')
                ->save($destination);

            $updateData['avatar'] = $newName;

            if (! empty($user['avatar'])) {
                $oldAvatar = $uploadPath
                    . DIRECTORY_SEPARATOR
                    . basename($user['avatar']);

                if (
                    basename($user['avatar']) !== 'default-avatar.png'
                    && is_file($oldAvatar)
                ) {
                    unlink($oldAvatar);
                }
            }
        }

        $userModel->update($id, $updateData);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'User account updated successfully.');
    }
}