<?php

namespace App\Http\Livewire\Components\Confirmation;

use App\Models\Kenderaan\Dokumen;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class ConfirmationDeleteDocument extends Component
{
    public $documentType, $docPath, $docName, $doc_id = -1, $currentId, $is_display, $currentTab, $message;

    protected $listeners = [
        'closeModal',
        'deleteDocumentMD' => 'initValue'
    ];

    public function initValue($documentType, $docPath, $docName, $docId, $currentId, $is_display, $currentTab, $message){

        $this-> currentId = $currentId;
        $this-> is_display = $is_display;
        $this-> currentTab = $currentTab;
        $this-> message = $message;
        $this-> documentType = $documentType;
        $this-> docPath = $docPath;
        $this-> docName = $docName;
        $this-> doc_id = $docId;

        Log::info(' hi --> '.$this-> doc_id);
    }

    public function deleteDocument(){

        $doc = Dokumen::find($this->doc_id);
        Log::info($doc);
        Log::info(app_path());
        $fullPath = 'app/public/'.$this->documentType.'/'.$this->docPath.'/'.$this->docName;
        Log::info(storage_path($fullPath));
        if(!empty($doc)){
            if(file_exists(storage_path($fullPath))){
                unlink(storage_path($fullPath));
                $doc->delete();
            }
        }

        return redirect()->route('vehicle.register', [
            'id' => $this->currentId,
            'is_display' => $this->is_display,
            'currentTab' => $this->currentTab,
             'success' => $this->message
        ]);

    }

    public function render()
    {
        return view('livewire.components.confirmation.confirmation-delete-document');
    }
}
