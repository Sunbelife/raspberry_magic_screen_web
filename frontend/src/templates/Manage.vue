<template>
    <div id="content">
        <h1>Magic Screen 管理</h1>
        <a-list
                :grid="{ gutter: 6, column: 3 }"
                :dataSource="data"
        >
            <a-list-item slot="renderItem" slot-scope="item">
                <a-card :headStyle="styleobj">
                    <img
                            alt="example"
                            :src="api + item.pic_dir"
                            slot="cover"
                    />
                    <template class="ant-card-actions" slot="actions">
                        <a-icon type="edit" @click="edit_card(item.id, item.pic_name)"/>
                        <a-icon type="delete" @click="delete_card(item.id)" />
                    </template>
                    <a-card-meta
                            :title="item.pic_name">
                    </a-card-meta>
                    <a-modal
                            title="编辑图片"
                            :visible="visible"
                            @ok="handleOk(item.id)"
                            :confirmLoading="confirmLoading"
                            @cancel="handleCancel"
                            :centered="true"
                            cancelText="取消修改"
                            okText="确认修改"
                    >
                        <p><a-icon type="edit" /> {{ModalText}}</p>
                        <a-input :placeholder="currentName" v-model="currentName"/>
                    </a-modal>
                </a-card>
            </a-list-item>
        </a-list>
        <a-upload-dragger id="upload_file" name="file" :multiple="true" :action="api + '/Pics/upload_pic'" @change="handleChange">
            <p class="ant-upload-drag-icon">
                <a-icon type="inbox" />
            </p>
            <p class="ant-upload-text">点击此处或拖动文件到这里来上传</p>
            <p class="ant-upload-hint">一次一个或者多个文件都可以</p>
        </a-upload-dragger>
        <a-button-group id="btn_grp">
            <a-button type="primary" @click="go_to_show" >开始展示</a-button>
            <a-button type="primary" @click="info" ><a-icon type="info" /></a-button>
        </a-button-group>
    </div>
</template>

<script>
    export default {
        name: "Manage",
        data () {
            return {
                data: [],
                api: process.env.VUE_APP_API_URL,
                ModalText: '在这里修改你想设置的图片名称',
                visible: false,
                confirmLoading: false,
                currentName: "default",
                styleobj :{
                    height: "10px",
                },
            }
        },
        beforeCreate () {
            this.$http.get('/Pics/get_all_pics')
                .then((response) => {
                    this.data = response
                    console.log(response.status)
                })
        },
        methods: {
            edit_card(id, name) {
                this.visible = true;
                this.currentName = name;
            },
            handleOk(id) {
                console.log(id)
                this.ModalText = '在这里输入你想设置的图片名称：';
                this.confirmLoading = true;
                setTimeout(() => {
                    this.visible = false;
                    this.confirmLoading = false;
                    this.$http.get('/Pics/edit_pic?id=' + id + "&name=" + this.currentName)
                        .then((response) => {
                            this.data = response
                            console.log(response.status)
                            this.$http.get('/Pics/get_all_pics')
                                .then((response) => {
                                    this.data = response
                                    console.log(response.status)
                                })
                        })
                }, 2000);
            },
            handleCancel(e) {
                this.$http.get('/Pics/get_all_pics')
                    .then((response) => {
                        this.data = response
                        console.log(response.status)
                    })
                this.visible = false
            },
            delete_card(e) {
                this.$http.get('/Pics/delete_one_pic?id=' + e)
                    .then((response) => {
                        this.data = response
                        console.log(response.status)
                        this.$http.get('/Pics/get_all_pics')
                            .then((response) => {
                                this.data = response
                                console.log(response.status)
                            })
                    })
            },
            info () {
                this.$message.info('Build For TechMan By Sunbelife');
            },
            handleChange(info) {
                const status = info.file.status;
                if (status !== 'uploading') {
                    console.log(info.file, info.fileList);
                }
                if (status === 'done') {
                    this.$http.get('/Pics/get_all_pics')
                        .then((response) => {
                            this.data = response
                            console.log(response.status)
                        })
                    this.$message.success(`${info.file.name} 文件上传完毕。`);
                } else if (status === 'error') {
                    this.$message.error(`${info.file.name} 文件上传失败。`);
                }
            },
            go_to_show(){
                this.$router.push({path:'/show'})
            }
        },
    }
</script>

<style scoped>
    #content {
        width: 80%;
        margin: 0 auto;
    }
    .ant-card-hoverable:hover {
        -webkit-box-shadow: 0 2px 8px rgba(0, 0, 0, 0.09);
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.16);
        border-color: rgba(0, 0, 0, 0.09);
    }
    #btn_grp {
        padding-top: 50px;
    }
    #upload_file {
        padding-top: 100px;
    }
</style>