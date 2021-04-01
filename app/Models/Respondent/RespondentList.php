<?php

namespace App\Models\Respondent;

use App\Imports\ContactsImport;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class RespondentList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'uuid', 'name', 'description', 'settings'];
    protected $casts = ['settings' => 'object'];
    protected $hidden = ['deleted_at', 'pivot.respondent_id', 'pivot'];

    private $acceptedFileFormats = ['xls', 'xlsx', 'csv', 'txt'];

    public function respondents()
    {
        return $this->belongsToMany(Respondent::class, 'respondents_to_lists');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function messages()
    {
        return $this->belongsToMany(RespondentDiscMessage::class, 'respondent_lists_to_messages');
    }

    public function acceptedFileFormat(String $fileFormat)
    {
        for ($i = 0; $i < count($this->acceptedFileFormats); $i++) {

            if ($fileFormat === $this->acceptedFileFormats[$i]) return true;
        }
        throw new \Exception('file format not accepted', 1);
        
    }

    public function uploadFile($base64File)
    {

        $base64Data = explode(',', $base64File['fileBase64'])[1];

        // dd($base64Data);

        try {

            $fileBin = base64_decode($base64Data);
            $fileName = $base64File['file_name'] . '.'.$base64File['file_format'];
            $filePath = auth()->user()->home_dir . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $fileName;
            $pathSize = public_path('storage/' . $filePath);
            $fileUrl = Storage::disk('public')->url($filePath);
            Storage::disk('public')->put($filePath, $fileBin);
            $filePath = Storage::disk('public')->path($filePath);

            $listImport = $this->imports()->create([
                'uuid' => Str::uuid(),
                'respondent_list_id' => $this->id,
                'name' => $base64File['file_name'],
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
