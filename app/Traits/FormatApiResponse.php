<?php

namespace App\Traits;

trait FormatApiResponse {

    protected function success($data, string $message = null, int $code = 200)
	{
        $response = ['status' => 'success'];
        
        if(!is_null($message)) {
            $response['message'] = $message;
        }

        if(!is_null($data)) {
            $response['data'] = $data;
        }

		return response()->json($response, $code);
	}

	protected function failed($errors, string $message = null, int $code)
	{
        $response = ['status'    => 'success'];
        
        if($message) {
            $response[] = ['message'   => $message];
        }

        if($errors) {
            $response[] = ['errors'   => $errors];
        }

		return response()->json($response, $code);
	}

}
