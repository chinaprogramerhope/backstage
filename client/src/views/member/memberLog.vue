<template>
  <div>
    <el-container>
      <el-main>

        <!-- 表单 -->
        <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">

          <el-form-item label="日期:">
            <el-date-picker
              v-model="form1.dateRange"
              type="daterange"
              range-separator="~"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
            />
          </el-form-item>

          <el-form-item label="用户ID:">
            <el-input v-model="form1.userId" placeholder="用户ID" clearable/>
          </el-form-item>

          <el-form-item label="IP:">
            <el-input v-model="form1.ip" placeholder="请输入ip" clearable/>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" icon="el-icon-search" @click="onGetLoginLog">查询</el-button>
          </el-form-item>
        </el-form>

        <!-- 表格 -->
        <el-table
          :data="tableData"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          stripe
          style="width: 100%; margin-bottom: 24px">
          <el-table-column prop="last_login_time" label="最后登录时间" align="center"/>
          <el-table-column prop="id" label="用户ID" align="center"/>
          <el-table-column prop="lastLoginIp" label="IP" align="center"/>
          <el-table-column prop="location" label="地址" align="center"/>
          <el-table-column prop="activate_device" label="设备" align="center"/>
        </el-table>

        <!-- 分页 -->
        <!-- <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        /> -->

      </el-main>
    </el-container>
  </div>
</template>

<script>
import { getLoginLog } from '@/api/member'

export default {
  data() {
    return {
      form1: {
        dateRange: '',
        id: '',
        ip: ''
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 1
    }
  },

  created() {
    const dateRange = this.form1.dateRange
    const userId = this.form1.userId
    const ip = this.form1.ip

    getLoginLog(dateRange, userId, ip).then(response => {
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
    onGetLoginLog() {
      const dateRange = this.form1.dateRange
      const userId = this.form1.userId
      const ip = this.form1.ip

      getLoginLog(dateRange, userId, ip).then(response => {
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

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
