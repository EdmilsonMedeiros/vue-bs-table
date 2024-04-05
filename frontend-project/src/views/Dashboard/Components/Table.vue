<template>
    <div class="container-fluid container-principal">
        <div class="container-table">
            <div class="row p-1">
                <div class="justify-content-start d-flex">
                    <div class="col-6 justify-content-start d-flex mb-2">
                        <div class="p-2">
                            <select :class="['form-select']" name="itemsPerPage" id="itemsPerPage" @change="selectionItemsPerPage()">
                                <option :value="selectedItemsPerPage" selected>{{ selectedItemsPerPage }}</option>
                                <option :value="10">10</option>
                                <option :value="25">25</option>
                                <option :value="50">50</option>
                                <option :value="100">100</option>
                            </select>
                        </div>
                        <div v-if="deleteAllButton && selectedRows.length > 0" class="p-2">
                            <button type="button" :class="['btn', 'btn-danger']" @click="destroyMany">{{ this.selectedRows.length }} <i class="bi bi-trash"></i> Deletar Selecionados</button>
                        </div>
                    </div>

                    <div :class="['col-6 col-md-4 offset-md-2 col-sm-4 offset-sm-2 mb-2 p-2 justify-content-end']">
                        <div class="">
                            <input class="form-control" type="text" name="searchedValue" v-model="searchedValue" id="" :placeholder="'Buscar'" />
                        </div>
                    </div>
                </div>
                <div :class="['col-12 col-sm-12 col-md-12 col-lg-12 p-3']">
                    <table :class="['table', 'table-striped']">
                        <thead>
                            <tr>
                                <th v-if="checkboxes && tableLoad"><input type="checkbox" :id="'checkAllBoxes'" @change="selectedAllRows()" style="width: 20px; height: 20px;" /></th>
                                <th v-for="(column, index) in columns" 
                                :key="index" scope="col">{{ column }} 
                                    <a href="#" @click="selectionSortBy(index)" 
                                    :class="['bi p-2', sortByIndex == index ? 'text-primary' : 'text-secondary', sortByIndex == index && orderAs == 'ASC' ? 'bi-arrow-down' : 'bi-arrow-down-up', sortByIndex == index && orderAs == 'DESC' ? 'bi-arrow-up' : 'bi-arrow-down-up', ]"></a></th>
                                <th v-if="buttons.length > 0">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div v-if="!totalRegisters" :class="['text-start']"><h3 :class="['text-secondary']">Nenhum Registro</h3></div>
                            <tr v-for="(row, index) in rows" :key="index">
                                
                                <td v-if="checkboxes && tableLoad">
                                    <input :id="'checkbox'+row.id" :value="row.id" type="checkbox" @change="selectedRow(row.id)" :class="['select-rows-checkbox']" style="width: 20px; height: 20px;"/>
                                </td>
                                <td v-for="(columnsRegister) in columnsRegisters">{{ row[columnsRegister] }}</td>
                                
                                <td v-if="buttons.length > 0">
                                    <button data-bs-toggle="tooltip" data-bs-title="Visualizar" v-if="buttons.includes('view')" @click="show(row)" type="button" :id="row.id" class="btn m-1 btn-primary"><i class="bi bi-eye text-white"></i></button>
                                    <button v-if="buttons.includes('edit')" @click="edit(row)" type="button" :id="row.id" class="btn m-1 btn-warning"><i class="bi bi-pencil text-white"></i></button>
                                    <button v-if="buttons.includes('delete')" @click="destroy(row)" type="button" :id="row.id" class="btn m-1 btn-danger"><i class="bi bi-trash text-white"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="container-pagination d-flex">
                        <div class="col-6 justify-content-start">
                            <h3 class="fs-6">Mostrando de {{ from }} até {{ to - 1 }} de {{ totalRegisters }} registros.</h3>
                        </div>
                        <div class="col-6 justify-content-right">
                            <nav v-if="pagination.pages > 1" aria-label="Page navigation">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item" :class="pagination.page <= 1 ? 'disabled' : ''">
                                        <a class="page-link" href="#" @click="paginatePrevious()">Anterior</a>
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
                                        <a class="page-link" href="#" @click="paginateNext()">Próximo</a>
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
        columns: Object,
        columnsRegisters: Object,
        rows: Object,
        from: Number,
        to: Number,
        pagination: Object,
        itemsPerPage: Number,
        paginationMax: Number,
        buttons: Array, // [ 'edit', 'delete', 'view']
        checkboxes: Boolean,
        deleteAllButton: Boolean,
        totalRegisters: Number,
    },
    data(){
        return {
            tableLoad: true,
            paginatorDefine: [],
            paginationLimit: this.paginationMax,
            searchedValue: null,
            selectedItemsPerPage: this.itemsPerPage,
            selectedRows: [],
            sortBy: null,
            orderAs: null,
            sortByIndex: null,
        }
    },
    watch: {
        searchedValue(){
            this.search()
        },
    },
    mounted() {
        this.paginateInArrayDivider();
    },
    methods: {
        getTableSet(){
            let data = {
                page: this.pagination.page, 
                value: this.searchedValue, 
                perpage: this.selectedItemsPerPage,
                sortBy: this.sortBy,
                orderAs: this.orderAs,
            }
            return data;
        },
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
            }else if(!countCheckeds == countTotal){
                document.getElementById('checkAllBoxes').checked = false;
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

                const checkboxes    = document.querySelectorAll('.select-rows-checkbox');
                let countCheckeds   = 0;
                let countTotal      = checkboxes.length;

                checkboxes.forEach(checkbox => {
                    if(checkbox.checked == true){
                        countCheckeds++;
                    }
                });

                if(countCheckeds < countTotal){
                    document.getElementById('checkAllBoxes').checked = false;
                }else if(countCheckeds == countTotal){
                    document.getElementById('checkAllBoxes').checked = true;
                }
            }else if(this.selectedRows.includes(value) && element.checked == false){
                const index = this.selectedRows.indexOf(value);
                if (index !== -1) {
                    element.checked == false;
                    this.selectedRows.splice(index, 1);
                    document.getElementById('checkAllBoxes').checked = false;
                }
            }
        },
        destroy(value){
            this.$emit('destroy-register' , value);
        },
        destroyMany(){
            this.$emit('destroy-many-registers' , this.selectedRows);
        },
        show(value){
            this.$emit('show-register' , value);
        },
        edit(value){
            this.$emit('edit-register' , value);
        },
        async selectionSortBy(index){
            switch(await this.orderAs){
                case null:
                    this.orderAs = 'ASC'
                    this.sortByIndex = index;
                    this.sortBy = await this.columnsRegisters[index];
                    break;
                case 'ASC':
                    this.orderAs = 'DESC'
                    this.sortByIndex = index;
                    this.sortBy = await this.columnsRegisters[index];
                    break;
                case 'DESC':
                    this.orderAs = null
                    this.sortBy = null;
                    this.sortByIndex = null;
                    break;
            }
            
            this.$emit('sort-by',
                this.getTableSet()
            );
            this.paginateInArrayDivider();
        },
        async selectionItemsPerPage(){
            this.pagination.page = 1;
            this.selectedItemsPerPage = await parseInt(document.getElementById('itemsPerPage').value);
            this.$emit('items-per-page', 
                this.getTableSet()
            );
            this.paginateInArrayDivider();
        },
        search(){
            this.$emit('searched-value', 
                this.getTableSet()
            );
            this.paginateInArrayDivider();
        },
        specificPaginaton(page){
            this.pagination.page = page;
            this.$emit('specific-pagination', 
                this.getTableSet()
            );
            this.paginateInArrayDivider();
        },
        paginateNext(){
            this.pagination.page = this.pagination.page+1,
            this.$emit('paginate',
                this.getTableSet()
            );
            this.paginateInArrayDivider();
        },
        paginatePrevious(){
            this.pagination.page = this.pagination.page-1,
            this.$emit('paginate', 
                this.getTableSet()
            );
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