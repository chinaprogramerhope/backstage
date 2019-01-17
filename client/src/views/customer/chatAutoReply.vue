<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="180px">

      <el-form-item label="关键词(英文逗号隔开):">
        <el-input v-model="form1.keyword" placeholder="关键词(英文逗号隔开)" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="回复内容:">
        <el-input v-model="form1.replyContent" placeholder="回复内容" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" @click="handleAdd()">添加</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="id" align="center"/>
      <el-table-column min-width="10%" prop="account" label="关键词" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="回复" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="warning" size="mini" @click="dialogEditVisible = true">修改</el-button>
          <el-button type="danger" size="mini" @click="handleDel()">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- dialog 修改 -->
    <el-dialog :visible.sync="dialogEditVisible" title="修改自动回复内容" center>
      <el-form :model="dialogFormEdit">
        <el-form-item>
          <span>关键词要用英文逗号隔开: ","</span>
        </el-form-item>

        <el-form-item label="关键词">
          <el-input v-model="dialogFormEdit.keyword" style="width: 400px"/>
        </el-form-item>

        <el-form-item label="回复">
          <el-input v-model="dialogFormEdit.replyContent" style="width: 400px"/>
        </el-form-item>

        <el-form-item>
          <el-button type="primary" size="mini" @click="dialogEditVisible = false">取消</el-button>
          <el-button type="primary" size="mini" @click="handleSubmit()">确定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        keyword: '',
        replyContent: ''
      },

      dialogEditVisible: false,
      dialogFormEdit: {
        keyword: '',
        replyContent: ''
      },

      tableData: [{
        id: '11'
      }]
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
