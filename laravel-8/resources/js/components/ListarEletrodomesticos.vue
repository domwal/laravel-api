<template>
    <div>
        <h1>Eletrodomésticos</h1>
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
                <label>Nome: </label>
                <input type="text" class="form-control" placeholder="Nome" v-model="post.nome">
            </div>
            <label>Descrição: </label>
            <div class="form-group">
                <textarea class="form-control" placeholder="Descrição" v-model="post.descricao"></textarea>
            </div>
            <div class="form-group">
                <label>Tensão: </label>
                <input type="text" class="form-control" placeholder="Tensão" v-model="post.tensao">
            </div>
            <div class="form-group">
                <label>Preço: </label>
                <input type="text" class="form-control" v-model.lazy="post.preco" v-money="money" v-model="post.preco" />
            </div>
            <div class="form-group">
                <label>Cor: </label>
                <input type="text" class="form-control" placeholder="Cor" v-model="post.cor">
            </div>
            <div class="form-group">
                <label>Marca: </label>
                <select class="form-control" id="marca_id" name="marca_id" v-model="post.marca_id">
                    <option value="">-- SELECIONE --</option>
                    <option v-for="marca in marcas" :value="marca.id">
                        {{marca.nome}}
                    </option>
                </select>
            </div>
            <p>
                <button type="submit" class="btn btn-success">{{ btn_submit.text }}</button>
                <button @click.prevent="resetForm()" class="btn btn-warning">Cancelar</button>
            </p>
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
                <button type="button" @click="editPost(post)" class="btn btn-success">Editar</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {VMoney} from 'v-money'

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
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: '',
                    suffix: '',
                    precision: 2,
                    masked: false /* doesn't work with directive */
                },
                errors: null,
                update: false,
                post_id: '',
                btn_submit: {
                    inserir: 'Inserir Novo',
                    atualizar: 'Atualizar',
                    text: 'Inserir Novo',
                }
            };
        },
        directives: {money: VMoney},

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
                let apidx = this.update === false ? 'api/eletro-domestico' : 'api/eletro-domestico/' + this.post.post_id;
                fetch(apidx, {
                    method: this.update === false ? 'post' : 'put',
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

                this.update = false;
                this.post.id = null;
                this.post.post_id = null;
                this.btn_submit.text = this.btn_submit.inserir;
                this.errors = null;
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
                            this.resetForm();
                            this.getPosts();
                        }
                    })
                    .catch(err => console.log(err));
            },

            editPost(post) {
                this.update = true;
                this.post.post_id = post.id;
                this.post.nome = post.nome;
                this.post.descricao = post.descricao;
                this.post.tensao = post.tensao;
                this.post.preco = post.preco;
                this.post.cor = post.cor;
                this.post.marca_id = post.marca_id;
                this.post.marca = post.marca;

                this.btn_submit.text = this.btn_submit.atualizar;
                this.errors = null;
                this.scrollToTop();
            },

            scrollToTop() {
                window.scrollTo(0,0);
            },



        }
    };
</script>