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
      <el-table-column min-width="10%" prop="userid" label="用户id" align="center"/>
      <el-table-column min-width="15%" prop="account" label="用户账号" align="center"/>
      <el-table-column min-width="10%" prop="registertime" label="注册时间" align="center"/>
      <el-table-column min-width="10%" prop="registerip" label="注册ip" align="center"/>
      <el-table-column min-width="15%" prop="registermac" label="注册mac" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="渠道" align="center"/>
      <el-table-column min-width="10%" prop="guest" label="是否游客" align="center"/>
    </el-table>

  </div>
</template>

<script>
import { userRegisterListGet } from '@/api/customer'

export default {
  data() {
    return {
      form1: {
        dateRange: ''
      },

      tableData: ''

    }
  },

  created() {
    userRegisterListGet(this.form1.dateRange).then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 查询
    handleGet() {
      userRegisterListGet(this.form1.dateRange).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>
