<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="left"
      label-width="120px">

      <el-row>
        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">刷新</el-button>
        </el-form-item>

        <el-form-item label="">
          <span>秒后自动刷新...</span>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">添加快捷回复</el-button>
        </el-form-item>
      </el-row>

      <el-row>
        <el-form-item label="用户id:">
          <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 150px"/>
        </el-form-item>

        <el-form-item label="">
          <el-button type="danger" size="small" @click="handleGet()">直接打开聊天通道</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">批量转客服</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">开启紧急回复</el-button>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">关闭人工充值</el-button>
        </el-form-item>
      </el-row>

      <el-row>
        <el-form-item label="">
          <span>当前状态: 当前</span>
        </el-form-item>

        <el-form-item label="">
          <el-button type="primary" size="small" @click="handleGet()">设置在线</el-button>
        </el-form-item>
      </el-row>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="用户id" align="center"/>
      <el-table-column min-width="10%" prop="account" label="渠道" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="内容" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="最后回复人" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="最后回复时间" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="操作" align="center">
        <template slot-scope="scope1">
          <el-button type="primary" size="mini">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        userId: ''
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
