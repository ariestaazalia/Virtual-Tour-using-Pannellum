<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Virtual Tour Fakultas Teknik Universitas Jenderal Soedirman</title>

        {{-- Bootstrap --}}
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" media="all">

        {{-- Icon --}}
        <link rel="icon" href="{{asset('img/UnsoedIcon.png')}}">

        <!-- Fonts -->
        <link href="//fonts.googleapis.com/css?family=Fahkwang:400,500,600,700" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">

        {{-- Css --}}
        <link rel="stylesheet" href="{{asset('css/base.css')}}">
        <link rel="stylesheet" href="{{asset('css/vendor.css')}}">  
        <link rel="stylesheet" href="{{asset('css/main.css')}}"> 

        {{-- Script --}}
        <script src="{{asset('js/modernizr.js')}}"></script>

        {{-- Pannellum--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

        <style>
        #pannellum {
            width: 100%;
            height: 100%;
            min-height: 804px;
            position: relative;
        }
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
            $("#hide").click(function(){
                $(".home-content-table").fadeOut(1000);
            });
            });
        </script>
    </head>
    
    <body id="top">

    <header> 
        <div class="header-logo"></div> 

        <a id="header-menu-trigger" href="#0">
            <span class="header-menu-text">Menu</span>
            <span class="header-menu-icon"></span>
        </a> 

        <nav id="menu-nav-wrap">
            <a href="#0" class="close-button" title="close"><span>Close</span></a>	

            <h3>Virtual Tour</h3>  

            <ul class="nav-list">
                <li class="current"><a class="smoothscroll" href="#home" title="">Home</a></li>
                <li><a class="smoothscroll" href="#about" title="">About</a></li>
                <li><a class="smoothscroll" href="#services" title="">Services</a></li>
                <li><a class="smoothscroll" href="#portfolio" title="">Works</a></li>
                <li><a class="smoothscroll" href="#contact" title="">Contact</a></li>						
            </ul>		
        </nav> 
    </header> 

    <!-- home--> 
    <div class="home-content-table">	
        <div class="home-content-tablecell">
            <div class="row">
                <div class="col-twelve">		   			
                    <h1 class="animate-intro"> Virtual Tour Fakultas Teknik Universitas Jenderal Soedirman </h1>	
                    <div class="more animate-intro">
                        <a id="hide" class="button stroke"> Start Tour </a>
                    </div>							
                </div> 
            </div>  
        </div> 		   
    </div>  

    <section id="pannellum">
        <div class="overlay"></div>
    </section> 

    <div id="preloader"> 
        <div id="loader"></div>
    </div> 

    
    <!-- Java Script --> 
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <script>
        pannellum.viewer('pannellum', {
            "default": {
                "firstScene": "{{$fscene->id}}",
                "author": "Universitas Jenderal Soedirman",
                "sceneFadeDuration": 1000
            },

            "scenes": { @foreach($scenes as $scene)
                "{{$scene->id}}": {
                    "title": "{{$scene->title}}",
                    "hfov": {{$scene->hfov}},
                    "pitch": {{$scene->pitch}},
                    "yaw": {{$fscene->yaw}},
                    "type": "{{$scene->type}}",
                    "panorama": "{{asset('/img/uploads/' . $scene->image)}}",
                    "autoLoad":true,
                    "autoRotate": -2,

                    "hotSpots": [@foreach ($hotspots->where('sourceScene', $fscene->id) as $hotspot)
                        {
                            "pitch": "{{$hotspot->pitch}}",
                            "yaw": "{{$hotspot->yaw}}",
                            "type": "{{$hotspot->type}}",
                            "text": "{{$hotspot->info}}",
                            "sceneId": "{{$hotspot->targetScene}}"
                        }, @endforeach
                    ]
                }, @endforeach
            }
        });
    </script> 
  </body>
</html>