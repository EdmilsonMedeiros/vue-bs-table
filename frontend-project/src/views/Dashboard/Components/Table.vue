<template>
    <div class="container-fluid container-principal">
            <h1 class="fs-2 text-center">Table Component</h1>
        <div class="container-table">
            <div class="row">
                <div class="container-fluid justify-content-end d-flex">
                    <div class="col-6 justify-content-end d-flex mb-2 p-2">
                        <div class="">
                            <input class="form-control" type="text" name="searchedValue" v-model="searchedValue" id="" :placeholder="'Buscar'" />
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <table v-if="tableLoad" :class="['table', classes]">
                        <thead>
                            <tr>
                                <th v-if="checkboxes"><input type="checkbox" :id="'checkAllBoxes'" class="" @change="selectedAllRows()" style="width: 20px; height: 20px;" /></th>
                                <th v-for="(column, index) in columns" :key="index" scope="col">{{ column }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in rows" :key="index">
                                <td v-if="checkboxes">
                                    <input :id="'checkbox'+row.id" :value="row.id" type="checkbox" @change="selectedRow(row.id)" class="select-rows-checkbox" style="width: 20px; height: 20px;"/>
                                </td>
                                <td v-for="(columnsRegister) in columnsRegisters">{{ row[columnsRegister] }}</td>
                                
                                <td v-if="buttons.length > 0">
                                    <button v-if="buttons.includes('view')" @click="show(row)" type="button" :id="row.id" class="btn m-1 btn-primary">Ver</button>
                                    <button v-if="buttons.includes('edit')" @click="edit(row)" type="button" :id="row.id" class="btn m-1 btn-warning">Editar</button>
                                    <button v-if="buttons.includes('delete')" @click="destroy(row)" type="button" :id="row.id" class="btn m-1 btn-danger">Deletar</button>
                                </td>
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

                                    <li v-for="(page, index) in paginatorDefine" :class="['page-item', page == pagination.page ? 'active' : '']">
                                        <a class="page-link" href="#" @click="specificPaginaton(page)">{{ page }}</a>
                                    </li>

                                    <li v-if="pagination.pages > paginationMax && pagination.page != pagination.pages" class="page-item disabled">
                                        <a class="page-link" href="#">{{ '...' }}</a>
                                    </li>

                                    <li v-if="pagination.pages > paginationMax && pagination.page != pagination.pages" :class="['page-item', pagination.page == pagination.pages ? 'active' : '']">
                                        <a class="page-link" href="#" @click="specificPaginaton(pagination.pages)">{{ pagination.pages }}</a>
                                    </li>

                                    <li :class="['page-item', !pagination.pages >= 1 ? 'disabled' : '' || pagination.page == pagination.pages ? 'disabled' : '', ]">
                                        <a class="page-link" href="#" @click="paginateNext()">Next</a>
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

<script>

export default {
    props: {
        classes: Object,
        columns: Object,
        columnsRegisters: Object,
        rows: Object,
        pagination: Object,
        itemsPerPage: Number,
        paginationMax: Number,
        buttons: Array, // [ 'edit', 'delete', 'view']
        checkboxes: Boolean,
    },
    data(){
        return {
            tableLoad: true,
            paginatorDefine: [],
            paginationLimit: this.paginationMax,
            searchedValue: null,

            selectedRows: [],
        }
    },
    watch: {
        searchedValue(value){
            this.search(value)
        },
    },
    mounted() {
        this.paginateInArrayDivider();
    },
    methods: {
        async tableReload(){
            this.tableLoad = false;
            await setTimeout(() => {
                this.tableLoad = true;
            }, 1);
            setTimeout(() => {
                this.loadSelectedCheckboxes();
            }, 1);
        },
        loadSelectedCheckboxes() {
            const checkboxes = document.querySelectorAll('.select-rows-checkbox');
            let countCheckeds = 0;
            let countTotal = 0;
            checkboxes.forEach(checkbox => {
                countTotal++;
                const checkboxId = parseInt(checkbox.value);
                if (this.selectedRows.includes(checkboxId)) {
                    countCheckeds++;
                    document.getElementById(checkbox.id).checked = true;
                }
            });
            if(countCheckeds == countTotal){
                document.getElementById('checkAllBoxes').checked = true;
            }
        },
        selectedAllRows() {
            const checkboxes = document.querySelectorAll('.select-rows-checkbox');
            checkboxes.forEach(checkbox => {
                const checkboxId = parseInt(checkbox.value);
                if (!this.selectedRows.includes(checkboxId) && !checkbox.checked) {
                    this.selectedRows.push(parseInt(checkbox.value));
                    checkbox.checked = true;
                }else if(this.selectedRows.includes(checkboxId) && checkbox.checked){
                    let index = this.selectedRows.indexOf(parseInt(checkbox.value));
                    if(index !== -1){
                        this.selectedRows.splice(index, 1);
                    }
                    checkbox.checked = false;
                }
            });
        },
        selectedRow(value){
            let element = document.getElementById('checkbox'+value);
            if(!this.selectedRows.includes(value) && element.checked == true){
                this.selectedRows.push(value);
            }else if(this.selectedRows.includes(value) && element.checked == false){
                const index = this.selectedRows.indexOf(value);
                if (index !== -1) {
                    element.checked == false;
                    this.selectedRows.splice(index, 1);
                }
            }
            
        },
        destroy(value){
            this.$emit('destroy-register' , value);
            // console.log(value);
        },
        show(value){
            this.$emit('show-register' , value);
            // console.log(value);
        },
        edit(value){
            this.$emit('edit-register' , value);
            // console.log(value);
        },
        search(value){
            this.$emit('searched-value', { value: value, page: this.pagination.page+1 });
            this.paginateInArrayDivider();
        },
        paginateNext(){
            this.$emit('paginate', { page: this.pagination.page+1, value: this.searchedValue });
            this.paginateInArrayDivider();
        },
        paginatePrevious(){
            this.$emit('paginate', { page: this.pagination.page-1, value: this.searchedValue });
            this.paginateInArrayDivider();
        },
        specificPaginaton(page){
            this.$emit('specific-pagination', { page: page, value: this.searchedValue });
            this.paginateInArrayDivider();

        },
        async paginateInArrayDivider() {
            await setTimeout(() => {
                this.tableReload();
                this.paginatorDefine = [];
                let contador = this.pagination.page;
                while (contador < this.pagination.page + this.paginationMax) {
                    if(contador <= this.pagination.pages){
                        this.paginatorDefine.push(contador);
                    }
                    contador++;
                }
            }, 1000);
        },
    },
}
</script>