<?php
\App\Models\User::updateOrCreate(
    ['email' => 'admin@wiratama-ma.com'],
    ['name' => 'Super Admin', 'password' => \Illuminate\Support\Facades\Hash::make('admin123'), 'role' => 'superadmin']
);
echo "Admin created successfully.\n";
