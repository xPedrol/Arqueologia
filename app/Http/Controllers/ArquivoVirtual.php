<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\DocumentArchive;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArquivoVirtual extends Controller
{
    public function home(Request $request)
    {
        $columns = [
            [
                'name' => 'Data de Produção',
                'key' => 'data_producao',
            ],
            [
                'name' => 'Localização',
                'key' => 'localizacao',
            ],
            [
                'name' => 'Identificação',
                'key' => 'identificacao',
            ],
            [
                'key' => 'data_insercao',
                'name' => 'Criação',
                'show' => Auth::user() !== null && Auth::user()->cargo == 'adm'
            ],
            [
                'name' => '',
                'key' => 'actions',
            ]
        ];
        $query = array();
        try {
            $nome = $request->query('nome');
            $palavraChave = $request->query('palavraChave');
            $ano = $request->query('ano');
            $localizacao = $request->query('localizacao');
            $queryBuilder = DB::table('documentos')->where((function ($query) use ($nome) {
                $query->where('emissor', 'like', '%' . $nome . '%')->orWhere('autor', 'like', '%' . $nome . '%')->orWhere('destinatario', 'like', '%' . $nome . '%');
            }))->where((function ($query) use ($palavraChave) {
                $query->where('identificacao', 'like', '%' . $palavraChave . '%')->orWhere('observacao', 'like', '%' . $palavraChave . '%');
            }))->where('data_producao', 'like', '%' . $ano . '%')
                ->where('localizacao', 'like', '%' . $localizacao . '%');
            //            return $queryBuilder->toSql();
            $maxPage = ceil($queryBuilder->count() / 15);
            PaginationHelper::instance()->handlePagination($request, $maxPage);
            $query = $request->query();
            $documentos = (isset($query['sort']) ? $queryBuilder->orderBy($query['sort'], $query['order']) : $queryBuilder)->paginate(15);
        } catch (Exception $e) {
            return view('arquivoVirtual.home', ['documentos' => array(), 'query' => $query, 'maxPage' => 0, 'columns' => $columns]);
        }
        return view('arquivoVirtual.home', ['documentos' => $documentos, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns]);
    }

    public function documentDetail(Request $request)
    {
        $id = $request->route('id');
        $document = DB::table('documentos')->where('id_documento', $id)->first();
        $files = DocumentArchive::where('documentId', $id)->get();
        return view('arquivoVirtual.documentDetail', ['document' => $document, 'files' => $files, 'documentId' => $id]);
    }

    //function to get column path from a document and search in the directory for a file
    public function getDocumentsInDisk($document)
    {
        $path = $document->path;
        //        $_SERVER['DOCUMENT_ROOT']
        try {
            print_r(Config::get('app.app_files_path').  $path.'<br>');
            $document_files = scandir(Config::get('app.app_files_path').  $path.'<br>');
            $document_files = array_slice($document_files, 2);
            print_r($document_files);
            return;
        } catch (Exception $e) {
            $document_files = array();
        }
        return $document_files;
    }

    public function documentDetailPDF(Request $request)
    {
        try {
            $id = $request->route('id');
            $documento = DocumentArchive::find($id);
            $path = $documento->path;
            $fullPath = Storage::disk('externo')->path(Config::get('app.app_files_path').$path);
            // Header content type
            header('Content-type: application/pdf');

            header('Content-Disposition: inline; filename="' . $fullPath . '"');

            header('Content-Transfer-Encoding: binary');

            header('Accept-Ranges: bytes');
            ini_set('memory_limit', '-1');
            // Read the file
            @readfile($fullPath);
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Arquivo não encontrado');
        }
    }

    public function documentDetailDownload(Request $request)
    {
        $id = $request->route('id');
        $archive = DocumentArchive::find($id);
        $path = $archive->path;
        if (!Storage::disk('externo')->exists(Config::get('app.app_files_path') . $path)) {
            return redirect()->back()->with('error', 'Arquivo não encontrado');
        }
//        return Storage::disk('externo')->download(Config::get('app.app_files_path') . $path);
        $pdfFilePath = Config::get('app.app_files_path') . $path;

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="example.pdf"',
        ];

        return response()->download($pdfFilePath, 'example.pdf', $headers);
    }

    public function getCallback()
    {
        // callback function that writes to php://output
        $callback = function() {
            //PDF

        };
        return $callback;
    }
}
