<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>JUMP!</title>
  </head>
  <body>
  <div class="container" id="app">
    <div class="row">
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="frog.jpg" class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title">Jump Frog</h5>
            <p class="card-text">{{requirement}}</p>
            <a href="#" class="btn btn-primary" @click="calculateJump">Calculate Jumps</a>
        
            </div>
            </div>
     </div>
           
            <div class="col">
            {{result}}
            {{message}}
            </div>
            
            </div>
            </div>
    </div>
   
    <!--Librerias-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
   
    <script>
        var app = new Vue({
        el: '#app',
        data: {
            requirement: 'cargando...',
            result: 'aqui va el resultado',
            message: '',
            
        },
        created: function(){
            this.getRequirement();
        },

        methods:{
            getRequirement:function(){
                var self = this;
                axios.get('jump.php?requirement=1')
                .then(function (response) {
                    self.requirement = response.data;
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            calculateJump:function(){
                this.result = "Calculando..."
                var self = this;
                axios.get('jump.php')
                .then(function (response) {
                    self.result = response.data;
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
         }
        
        })
    </script>

  </body>
</html>