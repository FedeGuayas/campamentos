<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Campamentos Deportivos</title>

    <!-- Font Awesome -->
    {!! Html::style('css/font-awesome.min.css') !!}


            <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap.min.css') !!}

            <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap-social.css') !!}

            <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    {{--    {!! Html::style('css/mdb.min.css') !!}--}}

            <!-- Material Design Bootstrap -->
    {!! Html::style('css/materialize.min.css') !!}

            <!-- Your custom styles (optional) -->
{{--        {!! Html::style('css/styleBack.css') !!}--}}


</head>

<body>

<div class="container-fluid">

    <header>

        <!-- Navbar goes here -->

        <!-- Dropdown Structure -->
        <ul id="dropdownUser" class="dropdown-content">
            <li><a href="#!">Info</a></li>
            <li><a href="#!">Datas</a></li>
            <li class="divider"></li>
            <li><a href="#!">Salir</a></li>
        </ul>
        <nav>
            <div class="nav-wrapper">

                <a href="" class="brand-logo center"><i class="material-icons">cloud</i> Logo</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="">Messages<span class="new badge blue" data-badge-caption="Msg nuevo">12</span></a>
                    </li>
                    <li><a href=""><i class="material-icons left">contact_mail</i>Contacto</a></li>
                    <li><a href="">New <span class="new badge red">4</span></a></li>
                    <!-- Dropdown Trigger -->
                    <li><a class="dropdown-button" href="#!" data-activates="dropdownUser">Usuario<i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
            </div>

        </nav>

    </header>


    <main>

        <!-- Page Layout here -->
        <div class="row">

            <div class="col s12 m4 l2 green" style="height: 100px"><span class="flow-text center-align">s12 m4 con un texto demasiado largoooooooo</span>
            </div>
            <div class="col s12 m4 l8 cyan"><span class="flow-text">s12 m4</span></div>
            <div class="col s12 m4 l2 grey"><span class="flow-text">s12 m4
            <ul id="dropdown2" class="dropdown-content">
                <li><a href="#!">one<span class="badge">1</span></a></li>
                <li><a href="#!">two<span class="new badge">1</span></a></li>
                <li><a href="#!">three</a></li>
            </ul>
  <a class="btn dropdown-button" href="#!" data-activates="dropdown2">Dropdown<i
              class="mdi-navigation-arrow-drop-down right"></i></a>
            </span></div>

        </div>


        {{--Botones--}}
        <a class="waves-effect waves-light btn-large disabled">Acciones<i class="material-icons right">cloud</i></a>
        <a class="waves-effect waves-light btn white-text"><i class="fa fa-facebook right white-text"></i>button</a>
        <a class="waves-effect waves-light btn"><i class="material-icons right">cloud</i>button</a>
        <a class="btn-floating btn-sm waves-effect waves-light blue"><i class="fa fa-facebook"></i></a>
        <a class="waves-effect waves-teal btn-flat">Button FLAT</a>
        <button class="btn waves-effect waves-light" type="submit" name="action">Enviar
            <i class="material-icons right">send</i>
        </button>


        {{--boton con acciones --}}
        <div class="fixed-action-btn horizontal click-to-toggle" style="bottom: 45px; right: 24px;">
            <a class="btn-floating btn-large red">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
                <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
                <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
                <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
            </ul>
        </div>


        {{--tarjetas--}}
        <div class="row">
            <div class="col s12 m7 l3">
                <div class="card small">
                    <div class="card-image">
                        <img src="../img/camp/atletismo-min.jpg">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information.
                            I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                    </div>
                </div>
            </div>

            <div class="col s12 m7 l3">
                <div class="card small sticky-action">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="http://lorempixel.com/100/190/nature/6">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Card Title<i
                                    class="material-icons right">more_vert</i></span>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Card Title<i
                                    class="material-icons right">close</i></span>
                        <p>Here is some more information about this product that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m7 l3">
                <div class="card-panel teal">
          <span class="white-text">I am a very simple card. I am good at containing small bits of information.
          I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
          </span>
                </div>
            </div>


            {{--chip--}}

        </div>

        <div class="row">
            <div class="col l6">
                <div class="chip">
                    <img src="images/yuna.jpg" alt="Contact Person">
                    Jane Doe
                    <i class="close material-icons">close</i>
                </div>

                <div class="chips">

                </div>

                <div class="chips chips-initial">

                </div>
                <div class="chips chips-placeholder">Hola</div>
            </div>
        </div>


        {{--FORMS--}}

        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="Entre el nombre" id="first_name" type="text" class="validate camp">
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" type="text" class="validate">
                        <label for="last_name">Last Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="I am not editable" id="disabled" type="text" class="validate">
                        <label for="disabled">Disabled</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>

                {{--Con iconos de prefijo--}}
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="icon_prefix" type="text" class="validate">
                                <label for="icon_prefix">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix">phone</i>
                                <input id="icon_telephone" type="tel" class="validate">
                                <label for="icon_telephone">Telephone</label>
                            </div>
                        </div>
                    </form>
                </div>

            </form>
        </div>


{{--Select--}}
        <div class="row">
            <div class="container">
            <div class="input-field col s12">
                <select>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </select>
                <label>Materialize Select</label>
            </div>

            <div class="input-field col s12">
                <select multiple>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </select>
                <label>Materialize Multiple Select</label>
            </div>

            <div class="input-field col s12">
                <select multiple>
                    <optgroup label="team 1">
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                    </optgroup>
                    <optgroup label="team 2">
                        <option value="3">Option 3</option>
                        <option value="4">Option 4</option>
                    </optgroup>
                </select>
                <label>Optgroups</label>
            </div>

            <div class="input-field col s12 m6">
                <select class="icons">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="" data-icon="images/sample-1.jpg" class="circle">example 1</option>
                    <option value="" data-icon="images/office.jpg" class="circle">example 2</option>
                    <option value="" data-icon="images/yuna.jpg" class="circle">example 1</option>
                </select>
                <label>Images in select</label>
            </div>
            <div class="input-field col s12 m6">
                <select class="icons">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="" data-icon="images/sample-1.jpg" class="left circle">example 1</option>
                    <option value="" data-icon="images/office.jpg" class="left circle">example 2</option>
                    <option value="" data-icon="images/yuna.jpg" class="left circle">example 3</option>
                </select>
                <label>Images in select</label>
            </div>

            <label>Browser Select</label>
            <select class="browser-default">
                <option value="" disabled selected>Choose your option</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
        </div>

        </div>


    </main>
    {{--/.Main--}}


    <footer class="page-footer  teal darken-1">
        <!-- Footer -->
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Footer Content</h5>
                    <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2014 Copyright Text
                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
        </div>
    </footer>
</div>

</body>
</html>


<!-- SCRIPTS -->

<!-- JQuery -->
{!! Html::script('js/jquery-3.1.0.min.js') !!}

        <!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}

        <!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}

        <!-- MDB core JavaScript -->
{{--{!! Html::script('js/mdb.min.js') !!}--}}

        <!-- Materialize core JavaScript -->
{!! Html::script('js/materialize.min.js') !!}

        <!--Google Maps-->
<script src="http://maps.google.com/maps/api/js"></script>

<script>
    function init_map() {

        var var_location = new google.maps.LatLng(-2.190098, -79.892341);

        var var_mapoptions = {
            center: var_location,

            zoom: 14
        };

        var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title: "FDGuayas"
        });

        var var_map = new google.maps.Map(document.getElementById("map-container"),
                var_mapoptions);

        var_marker.setMap(var_map);

    }

    google.maps.event.addDomListener(window, 'load', init_map);

</script>

<script>
    $('.chips').material_chip();
    $('.chips-initial').material_chip({
        data: [{
            tag: 'Apple',
        }, {
            tag: 'Microsoft',
        }, {
            tag: 'Google',
        }],
    });
    $('.chips-placeholder').material_chip({
        placeholder: 'Etiqueta',
        secondaryPlaceholder: '+Tag',
    });

    $(document).ready(function() {
        $('select').material_select();
    });
</script>

</body>

</html>