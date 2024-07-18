<?php

namespace App\Controllers;

use App\Models\Email;
use App\Validator;
use Exception;

class EmailController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function listEmails()
    {
        try {
            $emails = Email::all();
            return $this->jsonResponse([
                'status' => 'success',
                'data' => $emails
            ]);
        } catch (Exception $e) {
            return $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function showEmail($id)
    {
        try {
            if (!$id) {
                return $this->jsonResponse(['status' => 'error', 'message' => 'ID is required'], 400);
            }

            $mail = Email::find($id);

            if (!$mail) {
                return $this->jsonResponse(['status' => 'error', 'message' => 'mail not found'], 404);
            }

            return $this->jsonResponse([
                'status' => 'success',
                'data' => $mail
            ]);
        } catch (Exception $e) {
            return $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function createEmail()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonResponse(['status' => 'error', 'message' => 'Invalid JSON input'], 400);
            }

            $rules = [
                'recipient' => 'required|email',
                'subject' => 'required|string|max:255',
                'body' => 'required|string'
            ];

            $validation = $this->validator->validate($input, $rules);

            if ($validation !== true) {
                return $this->jsonResponse(['status' => 'error', 'errors' => $validation], 422);
            }

            $email = Email::create($input);

            return $this->jsonResponse([
                'status' => 'success',
                'data' => $email
            ], 201);
        } catch (Exception $e) {
            return $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteEmail($id)
    {
        try {
            if (!$id) {
                return $this->jsonResponse(['status' => 'error', 'message' => 'ID is required'], 400);
            }

            $mail = Email::find($id);
            if (!$mail) {
                return $this->jsonResponse(['status' => 'error', 'message' => 'mail not found'], 404);
            }

            $mail->delete();
            return $this->jsonResponse(['status' => 'success', 'data' => true]);
        } catch (Exception $e) {
            return $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function healthCheck()
    {
        return $this->jsonResponse(['status' => 'healthy']);
    }

    private function jsonResponse($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}
