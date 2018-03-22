<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
class ArticleController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */


     public function getArticles(){
        $listeArticles = Article::paginate(10);
        //dd($listeArticles);
        return Response()->json(['articles' => $listeArticles ]);
     }

     

     public function searchArticles($desig){
        $listeArticles = Article::where('designation',$desig)->paginate(10);
        //dd($listeArticles);
        return Response()->json(['articles' => $listeArticles ]);
     }

     public function getArticle($id_article){
       //dd(gettype ( $id_article ));
       $article = Article::find($id_article);
    
        return Response()->json(['article' => $article]);
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
          \Image::make($request->get('photo_art'))->save(public_path('images/').$name);
         
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
          \Image::make($request->get('photo_art'))->save(public_path('images/').$name);
         
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
        $article->delete();
        return Response()->json(['delete' => true]);
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
