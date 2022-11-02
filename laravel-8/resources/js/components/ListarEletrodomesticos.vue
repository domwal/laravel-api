<template>
    <div>
        <div v-if="errors" class="shadow-lg alert alert-danger" role="alert">
            <h4>Verifique os erros abaixo:</h4>
            <ul>
                <li v-for="(v, k) in errors" :key="k">
                    <span v-for="error in v" :key="error" class="text-sm">
                        {{ error }}
                    </span>
                </li>
            </ul>
        </div>
        <form @submit.prevent="addPost" ref="refEletrodomesticosForm">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Nome" v-model="post.nome">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Descrição" v-model="post.descricao"></textarea>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Tensão" v-model="post.tensao">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Preço" v-model="post.preco">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Cor" v-model="post.cor">
            </div>
            <div class="form-group">
                <select class="form-control" id="marca_id" name="marca_id" v-model="post.marca_id">
                    <option value="">-- SELECIONE --</option>
                    <option v-for="marca in marcas" :value="marca.id">
                        {{marca.nome}}
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>

        <nav>
            <ul class="pagination justify-content-center">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="getPosts(pagination.prev_page_url)">Anterior</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="#">{{ pagination.current_page }} de {{ pagination.last_page }}</a>
                </li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="getPosts(pagination.next_page_url)">Próximo</a>
                </li>
            </ul>
        </nav>
        <div class="card mb-2" v-for="post in posts" v-bind:key="post.id">
            <div class="card-body ">
                <h4 class="card-title">#{{ post.id }} - {{ post.nome }} - {{ post.tensao }}</h4>
                <p class="card-text">Preço: R$ {{ formatPrice(post.preco) }}</p>
                <p class="card-text">Cor: {{ post.cor }}</p>
                <p class="card-text">Marca: {{ post.marca.nome }}</p>
                <p class="card-text">{{ post.descricao }}</p>

                <button type="button" @click="deletePost(post.id)" class="btn btn-secondary">Remover</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                marcas: [],
                pagination: {},
                post: {
                    id: '',
                    nome: '',
                    descricao: '',
                    tensao: '',
                    preco: '',
                    cor: '',
                    marca_id: '',
                    marca: ''
                },
                errors: null,
            };
        },

        created() {
            this.getPosts();
            this.getMarcas();
        },

        methods: {
            getPosts(api_url) {
                let vm = this;
                api_url = api_url || '/api/listar-eletro-domestico';
                fetch(api_url)
                    .then(response => response.json())
                    .then(response => {
                        this.posts = response.data;
                        vm.paginator(response.meta, response.links);
                    })
                    .catch(err => console.log(err));
            },

            getMarcas(api_url) {
                let vm = this;
                api_url = api_url || '/api/listar-marcas';
                fetch(api_url)
                    .then(response => response.json())
                    .then(response => {
                        this.marcas = response.data;
                        console.log(this.marcas);
                    })
                    .catch(err => console.log(err));
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },

            paginator(meta, links) {
                this.pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
            },

            addPost() {
                fetch('api/eletro-domestico', {
                    method: 'post',
                    body: JSON.stringify(this.post),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success == false) {
                            // console.log(data.data);
                            this.errors = data.data;
                        }
                        else {
                            // esconde os avisos de erros
                            this.errors = null;
                            this.getPosts();
                            // limpar o formulario
                            this.resetForm();
                        }
                    })
                    .catch(err => console.log(err));
            },

            resetForm() {
                var self = this;
                Object.keys(this.post).forEach(function(key,index) {
                    self.post[key] = '';
                });
            },

            deletePost(id) {
                fetch('api/eletro-domestico/' + id, {
                    method: 'delete'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success == false) {
                            alert('Falha ao remover o Registro.');
                        }
                        else {
                            alert('Registro removido com sucesso.');
                            this.getPosts();
                        }
                    })
                    .catch(err => console.log(err));
            },



        }
    };
</script>