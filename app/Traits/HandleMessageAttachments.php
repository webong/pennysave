<?php

namespace App\Traits;

use App\Traits\UploadTrait;

trait HandleMessageAttachments
{

    use UploadTrait;

    public function handleAttachments($request)
    {
        return null;
        if ($request->has('attachment')) {
            $file = $this->upload('attachments', $request->attachment);
            $file = $request->file('attachment')->store('attachments', 'public');
        }

    }
}