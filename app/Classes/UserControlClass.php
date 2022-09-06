<?php 
namespace App\Classes;

use App\User;
use App\Provider;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserControlClass {
    public function saveUser($data,$usertype)
    {
        $user = User::where('email', $data['email'])->where('isdelete', false)->get();
        if(count($user))
        {
            $user[0]->email = $data['email'];
            $user[0]->name = $data['name'];
            $user[0]->phone = $data['phone'];
            if(isset($data['new_password']) && $data['new_password'] != "")
                $user[0]->password = Hash::make($data['new_password']);
            $user[0]->update();
            $user[0]->assignRole($usertype);
            return $user[0];
        }
        $data['isdelete'] = false;
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'isdelete' => $data['isdelete'],
            'password' => Hash::make($data['new_password']),
        ]);
        $newUser->assignRole($usertype);
        return $newUser;
    }

    public function updateUser($id, $data, $usertype)
    {
        $users = User::find($id);
        $users->email = $data['email'];
        $users->name = $data['name'];
        $users->phone = $data['phone'];
        if(isset($data['new_password']) && $data['new_password'] != "")
            $users->password = Hash::make($data['new_password']);
        $users->update();
        $users->assignRole($usertype);
        return $users;
    }

    public function saveProvider($data)
    {
        $user = self::saveUser($data, "Provider");
        Provider::create([
            'companyname' => $data['companyname'],
            'addline1' => $data['addline1'],
            'country' => $data['country'],
            'cp' => $data['cp'],
            'user_id' => $user->id,
        ]);
    }

    public function saveClient($data)
    {
        $user = self::saveUser($data, "Client");
        Client::create([
            'companyname' => $data['companyname'],
            'addline1' => $data['addline1'],
            'country' => $data['country'],
            'cp' => $data['cp'],
            'numberofemployees' => $data['numberofemployees'],
            'service' => $data['service'],
            'payment' => $data['payment'],
            'user_id' => $user->id,
        ]);
    }

    public function editProvider($id, $data)
    {
        $providers = Provider::find($id);
        $user = self::updateUser($providers->user_id, $data, "Provider");
        $providers->companyname = $data['companyname'];
        $providers->addline1 = $data['addline1'];
        $providers->country = $data['country'];
        $providers->cp = $data['cp'];
        $providers->user_id = $user->id;
        $providers->update();
    }

    public function editClient($id, $data)
    {
        $clients = Client::find($id);
        $user = self::updateUser($clients->user_id, $data, "Client");
        $clients->companyname = $data['companyname'];
        $clients->addline1 = $data['addline1'];
        $clients->country = $data['country'];
        $clients->cp = $data['cp'];
        $clients->numberofemployees = $data['numberofemployees'];
        $clients->service = $data['service'];
        $clients->payment = $data['payment'];
        $clients->user_id = $user->id;
        $clients->update();
    }
}
