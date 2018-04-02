<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Famille_article;
use App\Tva;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
class ArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */


     public function getArticles(){
       // dd(Storage::disk('local')->delete('images/1521897359.png'));
     // dd( public_path('images/').'1521897359.png');
        $listeArticles = Article::paginate(10);
        //dd($listeArticles);
        return Response()->json(['articles' => $listeArticles ]);
     }

    
    
     public function searchArticles($desig){
        $listeArticles = Article::where('designation','like', '%' .$desig . '%')->orWhere('reference_art','like', '%' .$desig . '%')->paginate(10);
        //dd($listeArticles);
        return Response()->json(['articles' => $listeArticles ]);
     }

     public function getArticle($id_article){
        $article = Article::find($id_article);
        $libelle_famille = Famille_article::withTrashed()->select('libelle_famille')->where('id_famille','=',$article->fk_famille)->get();      
        $taux_tva = DB::table('tvas')->select('taux_tva')->where('id_tva','=',$article->fk_tva_applicable)->get();
        
    
        return Response()->json(['article' => $article , 'libelle_famille' => $libelle_famille ,'taux_tva' => $taux_tva ]);
     }


    public function index()
    {
        $listeArticles = Article::all();
       //dd($listeArticles);
       return Response()->json(['' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { //dd($request);
        
        $article = new Article();
        if($request->get('photo_art'))
       {  
           if(strlen($request->get('photo_art')) < 40 ){
            $article->photo_art = $request->get('photo_art');
           }
           else {
          $image = $request->get('photo_art');
          $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
         $image2 = \Image::make($request->get('photo_art'));     
          Storage::put('images/'.$name, (string) $image2->encode());
          $article->photo_art = $name;}
        }
        else  {
            $article->photo_art = "";
        }
                

        
                $article->reference_art = $request->reference_art;
                $article->type_art = $request->type_art;
                $article->designation = $request->designation;
                $article->description = $request->description;
                $article->prix_ht_achat = $request->prix_ht_achat;
                $article->prix_ht_vente = $request->prix_ht_vente;
                $article->unite = $request->unite;
                $article->quantite = $request->quantite;
                $article->quantite_min = $request->quantite_min;
                
                $article->fk_tva_applicable = $request->fk_tva_applicable;
                $article->fk_famille = $request->fk_famille;
                $article->save();
   
                 return Response()->json(['etat' => true]);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function updateArticle(Request $request)
    {
        $article = Article::find($request->id_article);
        //$article = new Article();
        if($request->get('photo_art'))
       {  
           if(strlen($request->get('photo_art')) < 40 ){
            $article->photo_art = $request->get('photo_art');
           }
           else {
          $image = $request->get('photo_art');
          $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          if( $article->photo_art !=""){
          Storage::disk('local')->delete('images/'.$article->photo_art);
          }

          $image2 = \Image::make($request->get('photo_art'));     
          Storage::put('images/'.$name, (string) $image2->encode());
          $article->photo_art = $name;}
        }
        else  {
            $article->photo_art = "";
        }
                

        
                $article->reference_art = $request->reference_art;
                $article->type_art = $request->type_art;
                $article->designation = $request->designation;
                $article->description = $request->description;
                $article->prix_ht_achat = $request->prix_ht_achat;
                $article->prix_ht_vente = $request->prix_ht_vente;
                $article->unite = $request->unite;
                $article->quantite = $request->quantite;
                $article->quantite_min = $request->quantite_min;
                
                $article->fk_tva_applicable = $request->fk_tva_applicable;
                $article->fk_famille = $request->fk_famille;
                $article->save();
                 return Response()->json(['etat' => true]);
    }
    
    public function deleteArticle($id_article){
       // dd($id_article);
       
        $article = Article::find($id_article);
        if( $article->photo_art !=""){
        Storage::disk('local')->delete('images/'.$article->photo_art);}
        $article->delete();
        return Response()->json(['delete' => 'ooook']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
