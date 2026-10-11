<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'     => 'Customer Accounts',
            'customers' => $customerModel->findAll()
        ];

        return view('customers/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'New Customer'
        ];

        return view('customers/new', $data);
    }

    public function create()
    {
        $rules = [
            'full_name' => [
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'The full name is required.',
                    'max_length' => 'The full name cannot exceed 100 characters.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required'    => 'The email address is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'max_length'  => 'The email cannot exceed 100 characters.'
                ]
            ],
            'phone' => [
                'rules'  => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'The phone number cannot exceed 20 characters.'
                ]
            ]
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $customerModel = new CustomerModel();

        $customerModel->insert([
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone'))
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer account created successfully.');
    }

    public function edit(int $id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound(
                'Customer account not found.'
            );
        }

        $data = [
            'title'    => 'Edit Customer',
            'customer' => $customer
        ];

        return view('customers/edit', $data);
    }

    public function update(int $id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound(
                'Customer account not found.'
            );
        }

        $rules = [
            'full_name' => [
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'The full name is required.',
                    'max_length' => 'The full name cannot exceed 100 characters.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required'    => 'The email address is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'max_length'  => 'The email cannot exceed 100 characters.'
                ]
            ],
            'phone' => [
                'rules'  => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'The phone number cannot exceed 20 characters.'
                ]
            ]
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $customerModel->update($id, [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone'))
        ]);

        return redirect()
            ->to(site_url('customers'))
            ->with('success', 'Customer account updated successfully.');
    }
}