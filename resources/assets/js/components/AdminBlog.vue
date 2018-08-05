<template>
    <div>
        <h3 class="admin-panel-title">List of Blog</h3>
        <v-client-table
                :data="tableData"
                :columns="columns"
                :options="options">
        </v-client-table>
    </div>
</template>
<script>
    export default{
        mounted() {
            this.fetchBlog();
        },
        data(){
            return{
                columns: ['id','title','updated_at','status','delete', 'edit'],
                tableData: [],
                options: {
                    compileTemplates: true,
                    pagination: {
                        dropdown:true,
                        chunk:10
                    },
                    perPage: 50,
                    filterByColumn: false,
                    texts: {
                        filter: "Search: "
                    },
                    datepickerOptions: {
                        showDropdowns: true
                    },
                    sortIcon: {
                        base:'fa',
                        up:'fa-chevron-up',
                        down:'fa-chevron-down'
                    },
                    sortable: ['id','title','status'],
                    orderBy:{
                        column: 'id',
                        ascending: false
                    },
                    templates:{
                        title: function(createElement, row){
                            return createElement('a',{
                                attrs:{
                                    'href': '/blog-details/' + row.slug,
                                    'target': '_blank',
                                    'class': "link"
                                },
                                domProps: {
                                    innerHTML: row.title
                                },
                            });
                        },
                        status: function(creatElement, row){
                            var publish = (row.published == 1 ? "Published": "Unpublished");

                            return creatElement('span',{
                                domProps: {
                                    innerHTML: publish
                                },
                            });
                        }
                        ,delete: function(createElement, row){
//                            return createElement('router-link',{
//                                attrs:{
//                                    'to': '/admin/blog/' + row.id,
//                                    'class': "link"
//                                },
//                                domProps: {
//                                    innerHTML: "Edit"
//                                },
//                            });
                            return createElement('a',{
                                attrs:{
                                    'href': 'javascript:void(0);',
                                    'class': "link",
                                    'data-id': row.id,
                                },
                                domProps: {
                                    innerHTML: "Delete"
                                },
                                on: {
                                    click: function(e){
                                        var r = confirm("Are you sure to delete blog with id " + $(e.srcElement).attr('data-id') + "?");
                                        if (r == true) {
                                            window.location.href = "/admin/blog/delete/" + $(e.srcElement).attr('data-id');
                                        }
//                                        return _deleteBlog($(e.srcElement).attr('data-id'));
//                                        return this.$http.delete("/admin/blog/delete/" + $(e.srcElement).attr('data-id'));
                                    }
                                },
                            });
                        },
                        edit: function(createElement, row){
                            return createElement('a',{
                                attrs:{
                                    'href': '/admin/blog/'+ row.id,
                                    'class': "link",
                                    'data-id': row.id,
                                    'data-publish': row.published,
                                },
                                domProps: {
                                    innerHTML: "Edit"
                                },
                                on: {
                                    click: function(e){

                                        console.log($(e.srcElement).attr('data-id'));

                                    }
                                },
                            });
                        },
                    }
                }
            }
        },
        methods:{
            fetchBlog:function(){
                return this.$http.get("/admin/blog-data")
                    .then((resp)=>{
                        console.log(resp);
                        this.tableData = resp.body;
                        return true;
                    }).catch(function (err) {
                    }).bind(this);
            },
            deleteBlog:function (id) {
                console.log(id);
            }
        }
    }

</script>
