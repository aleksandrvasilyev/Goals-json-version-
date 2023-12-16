<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Goal
{
    private $id;
    private $name;
    private $description;
    private $category;
    private $author = '';
    private $data;
    private $jsondata;

    const file = 'db.json';

    public function __construct()
    {
    }

    private function file_to_json()
    {
        return json_decode(file_get_contents(self::file), true);
    }

    private function change_data_in_array($id_goal, $id)
    {
        $json_data = $this->file_to_json();

        $json_data[$id]['id'] = $id_goal;
        $json_data[$id]['name'] = htmlspecialchars_decode(trim($_POST['name']));
        $json_data[$id]['description'] = htmlspecialchars_decode(trim($_POST['description']));
        $json_data[$id]['category'] = htmlspecialchars_decode(trim($_POST['category']));
        $json_data[$id]['author'] = 'Author';
        $json_data[$id]['date'] = date("d.m.Y H:i:s");
        $json_data[$id]['status'] = htmlspecialchars_decode(trim($_POST['status']));

        return $json_data;
    }

    private function put_data_to_file($json_data)
    {
        file_put_contents(self::file, json_encode($json_data, JSON_PRETTY_PRINT));
    }


    private function get_id_in_json($id)
    {
        $json_data = json_decode(file_get_contents(self::file), true);
        foreach ($json_data as $key => $value) {
            if ($json_data[$key]['id'] == $id) {
                return $key;
            }
        }
    }

    public function add()
    {
        $json_data = $this->file_to_json();
        $id = array_key_last($json_data) + 1;
        $id_goal = array_values(array_slice($json_data, -1))[0]['id'] + 1;
        $json_data = $this->change_data_in_array($id_goal, $id);
        $this->put_data_to_file($json_data);
    }

    public function edit()
    {
        $json_data = $this->file_to_json();
        $id = $this->get_id_in_json(htmlspecialchars_decode(trim($_POST['id'])));
        $id_goal = $_POST['id'];
        $json_data = $this->change_data_in_array($id_goal, $id);
        $this->put_data_to_file($json_data);
    }

    public function update_status()
    {
        $json_data = $this->file_to_json();
        $id = $this->get_id_in_json(htmlspecialchars_decode(trim($_POST['id'])));
        if (htmlspecialchars_decode(trim($_POST['status'])) == 'on') {
            $new_status = 'off';
        } else {
            $new_status = 'on';
        }
        $json_data[$id]['status'] = $new_status;
        $this->put_data_to_file($json_data);
    }

    public function delete()
    {
        $json_data = $this->file_to_json();
        $id = $this->get_id_in_json(htmlspecialchars_decode(trim($_POST['id'])));
        unset($json_data[$id]);
        $this->put_data_to_file($json_data);
    }
}

$goal = new Goal();

switch (htmlspecialchars_decode(trim($_POST['action']))) {
    case 'add':
        $goal->add();
        break;
    case 'edit':
        $goal->edit();
        break;
    case 'delete':
        $goal->delete();
        break;
    case 'update':
        $goal->update_status();
        break;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
