<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-form-item label="日期:">
        <el-date-picker
          v-model="form1.dateRange"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="yyyy-MM-dd HH:mm:ss"
          style="width:250px"
        />
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="用户id" align="center"/>
      <el-table-column min-width="10%" prop="account" label="用户账号" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="注册时间" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="注册ip" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="注册mac" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="渠道" align="center"/>
      <el-table-column min-width="10%" prop="account" label="是否游客" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        dateRange: ''
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
