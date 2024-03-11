<script>

export default {
    props: {
        classes: Object,
        columns: Object,
        rows: Object,
        pagination: Object,

        itemsPerPage: Number,
        paginationMax: Number
    },
    data(){
        return {
            paginatorDefine: [],
            paginationLimit: this.paginationMax,
        }
    },
    mounted() {
        console.log("Teste: " + Math.max(100, 150));
        this.paginateInArrayDivider();
    },
    methods: {
        paginatePrevious(){
            this.$emit('paginate', this.pagination.page-1);
            this.paginateInArrayDivider();
        },
        paginate(){
            this.$emit('paginate', this.pagination.page+1);
            this.paginateInArrayDivider();
        },
        specificPaginaton(page){
            this.$emit('specific-pagination', page);
            this.paginateInArrayDivider();
        },
        paginateInArrayDivider() {
            setTimeout(() => {
                this.paginatorDefine = [];
                let contador = this.pagination.page;

                while (contador < this.pagination.page + this.paginationMax) {
                    // Adiciona o número ao array
                    if(contador <= this.pagination.pages){
                        this.paginatorDefine.push(contador);
                    }
                    contador++; // Incrementa o contador
                }

            }, 900);
        }
    },
}
</script>

<script setup>

</script>

<template>
    <div class="container-fluid container-principal">

        <h1 class="fs-2 text-center">Table Component</h1>

        <div class="container-table">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <table :class="['table', classes]">
                        <thead>
                            <tr>
                                <th v-for="(column, index) in columns" :key="index" scope="col">{{ column }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in rows" :key="index">
                                <td>{{ row.name }}</td>
                                <td>{{ row.email }}</td>
                                <td>{{ row.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="container-pagination d-flex">
                        
                        <div class="col-6 justify-content-start">
                            <h3 class="fs-6">Mostrando página {{ pagination.page }} de {{ pagination.pages }} páginas</h3>
                        
                        </div>
                        <div class="col-6 justify-content-right">
                            <nav v-if="pagination.pages > 1" aria-label="Page navigation">
                                <ul class="pagination justify-content-end">

                                    <li class="page-item" :class="pagination.page <= 1 ? 'disabled' : ''">
                                        <a class="page-link" href="#" @click="paginatePrevious()">Previous</a>
                                    </li>

                                    <li v-if="pagination.page > 1 && pagination.page <= pagination.pages" class="page-item">
                                        <a class="page-link" href="#" @click="specificPaginaton(1)">{{ 1 }}</a>
                                    </li>

                                    <li v-if="pagination.page > 1 && pagination.page <= pagination.pages" class="page-item disabled">
                                        <a class="page-link" href="#">{{ '...' }}</a>
                                    </li>

                                    <li v-for="(page, index) in paginatorDefine" class="page-item">
                                        <a class="page-link" href="#" @click="specificPaginaton(page)">{{ page }}</a>
                                    </li>

                                    <li v-if="pagination.pages > paginationMax && pagination.page != pagination.pages" class="page-item disabled">
                                        <a class="page-link" href="#">{{ '...' }}</a>
                                    </li>

                                    <li v-if="pagination.pages > paginationMax && pagination.page != pagination.pages" class="page-item">
                                        <a class="page-link" href="#" @click="specificPaginaton(pagination.pages)">{{ pagination.pages }}</a>
                                    </li>

                                    <li class="page-item" :class="!pagination.pages >= 1 ? 'disabled' : ''">
                                        <a class="page-link" href="#" @click="paginate()">Next</a>
                                    </li>

                                </ul>
                            </nav>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>