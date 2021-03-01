<?php

namespace App\Models\Respondent;

use App\Imports\ContactsImport;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RespondentList extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'uuid', 'name', 'description', 'settings'];
    protected $casts = ['settings' => 'object'];

    public function respondents()
    {
        return $this->hasMany(Respondent::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
   
    public function messages()
    {
        return $this->belongsToMany(RespondentDiscMessage::class, 'respondent_lists_to_messages');
    }

    public function uploadFile($base64File)
    {
        try {

            $fileBin = base64_decode($base64File);
            $fileName = uniqid() . '.xlsx';
            $filePath = auth()->user()->home_dir . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $fileName;
            $pathSize = public_path('storage/' . $filePath);
            $fileUrl = Storage::disk('public')->url($filePath);
            Storage::disk('public')->put($filePath, $fileBin);
            $filePath = Storage::disk('public')->path($filePath);


            $listImport = $this->imports()->create([
                'respodent_list_id' => $this->id,
                'name' => $fileName,
                'file_size' => File::size($pathSize),
                'file_path' => auth()->user()->home_dir . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $fileName,
                'file_url' => $fileUrl
            ]);


            Excel::import(new ContactsImport($listImport), $filePath);

            return $listImport;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    public function imports()
    {
        return $this->hasMany(RespondentListImport::class, 'respondent_list_id');
    }
}
