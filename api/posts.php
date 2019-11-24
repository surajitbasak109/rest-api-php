<?php

if ($method == 'GET') {
  if ($id) {
    $data = DB::query("SELECT * FROM $tableName WHERE id = :id", [
      ':id' => $id
    ]);
    if ($data != null) {
      echo json_encode($data[0]);
    } else {
      echo json_encode(['message' => 'Currently there are no posts in the database.']);
    }
  } else {
    $data = DB::query("SELECT * FROM $tableName");
    echo json_encode($data);
  }
} elseif ($method == 'POST') {
  if ($_POST != null && !$id) {
    extract($_POST);
    $now = date('Y-m-d H:i:s');
    DB::query("INSERT INTO $tableName VALUES (null, :title, :body, :author, :created_on, null)", [
      ':title' => $title,
      ':body' => $body,
      ':author' => $author,
      ':created_on' => $now
    ]);
    $data = DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
    echo json_encode([
      'message' => 'Post added to the database successfully.',
      'success' => true,
      'post' => $data[0]
    ]);
  } else {
    echo json_encode([
      'message' => 'Pleas fill in all the credentials.',
      'success' => false
    ]);
  }
} elseif ($id) {
  $post = DB::query("SELECT * FROM $tableName WHERE id = :id", [':id' => $id]);
  if ($post != null) {
    if ($method == 'PUT') {
      extract(json_decode(file_get_contents('php://input'), true));
      echo $title . ', ' . $body . ', ' . $author;
      // Update the post in the database
      $now = date("Y-m-d H:i:s");
      DB::query("UPDATE $tableName SET title = :title, body = :body, author = :author, updated_at = :updated_at WHERE id = :id", [
        ':title' => $title,
        ':body' => $body,
        ':author' => $author,
        ':updated_at' => $now,
        ':id' => $id
      ]);

      $data = DB::query("SELECT * FROM $tableName WHERE id = :id", [":id" => $id]);
      echo json_encode([
        'post' => $data[0],
        'message' => 'Post Updated successfully.',
        'success' => true
      ]);
    } elseif ($method == 'DELETE') {
      DB::query("DELETE FROM $tableName WHERE id = :id", [":id" => $id]);
      echo json_encode([
        'message' => 'Post Deleted successfully.',
        'success' => true
      ]);
    }
  } else {
    echo json_encode([
      'message' => 'Post not found.',
      'success' => false
    ]);
  }
}
