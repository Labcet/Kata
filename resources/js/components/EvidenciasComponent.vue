<template>
    <div>
        <div style="width: 100%; text-align: right;">
            <button class="btn btn-primary" type="button" v-on:click="changeFlagEvidences()">
                Desplegar
            </button>
        </div><br>
        <div v-if="showEvidences">
            <div v-if="aprobadoFlag == 'pendiente'">
                <button type="button" style="background: #ff287b; border: none;" class="btn btn-primary" v-on:click="changeFlag()">Agregar evidencia</button>
            </div><br>
            <div v-if="showForm">
                <form @submit="createEvidencia" enctype="multipart/form-data">
                    <input type="text" id="Id" v-model="evidencia.cp_id" hidden>
                    <div class="mb-3">
                        <label for="Imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" name="Imagen" id="Imagen" v-on:change="onFileChange">
                    </div>
                    <input type="text" id="path" v-model="evidencia.path" hidden>
                    <div class="mb-3">
                        <label for="Resultado" class="form-label">Comentario</label>
                        <input type="text" class="form-control" id="Resultado" v-model="evidencia.comentario">
                        <small id="emailHelp" class="form-text text-muted">Ingrese un comentario si lo cree necesario.</small>
                    </div><br>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <br><br>
                </form>
            </div>

            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Comentario</th>
                        <th scope="col">Fecha y hora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(evidencia, index) in evidencias" :key="evidencia.id">
                        <td>{{ index+1 }}</td>
                        <td><img :src="''+evidencia.path" style="width: 150px; object-fit: cover;"></td>
                        <td>{{ evidencia.comentario }}</td>
                        <td>{{ evidencia.fecha_hora }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        
        props: {

            idCp: Number,
            aprobadoCp: String

        },

        created(){

            //console.log(this.aprobadoCp)
        },

        data(){
            return{

                aprobadoFlag: this.aprobadoCp,

                testCaseIdProp: null,
                showForm: false,
                showEvidences: false,
                evidencias:[],
                evidencia:{

                    cp_id: this.idCp,
                    imagen: "",
                    path: "",
                    comentario: "",
                    fecha_hora: ""
                }
            }
        },

        computed:{
            //console.log(this.aprobadoCp)
        },

        mounted() {

            this.showEvidencias();
            //console.log(this.idCp)
            //console.log(this.aprobadoCp)
        },

        methods:{

            showEvidencias(){

                axios.get('/api/evidencias/' + this.idCp)
                .then(response=>{
                    this.evidencias = response.data
                })
                .catch(error=>{
                    alert(error);
                    console.log(error)
                })
            },

            createEvidencia(e){
                
                e.preventDefault();
                let existingObj  = this;

                const config = {
                    headers: { 
                        'content-type': 'multipart/form-data' 
                    }
                }

                let data = new FormData();
                data.append('cp_id', this.evidencia.cp_id);
                data.append('imagen', this.evidencia.imagen);
                data.append('path', this.evidencia.path);
                data.append('comentario', this.evidencia.comentario);
                data.append('fecha_hora', this.evidencia.fecha_hora);

                axios.post('/api/evidencias', data, config)
                .then(response=>{
                    //this.$router.push({name:"mostrarDocumentos"});
                    //console.log(response.data)
                    window.location.href = '/dashboard';
                })
                .catch(error=>{
                    alert(error);
                    console.log(error);
                })
            },

            changeFlag(){

                if(!this.showForm){

                    this.showForm = true;
                } else {

                    this.showForm = false;
                }
            },

            changeFlagEvidences(){

                if(!this.showEvidences){

                    this.showEvidences = true;
                } else {

                    this.showEvidences = false;
                }  
            },

            onFileChange(e){

                //console.log(e.target.files[0]);
                this.evidencia.imagen = e.target.files[0];
            },

            /*borrarDocumento(id){

                if(confirm("¿confirma eliminar el registro")){
                    axios.delete('/api/documentos/' + id)
                    .then(response=>{
                        this.showDocuments()
                    })
                    .catch(error=>{
                        alert(error);
                        console.log(error)
                    })          
                }
            }*/
        }
    }
</script>
