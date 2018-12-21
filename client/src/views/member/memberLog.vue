<template>
  <div>
    <el-container>
      <el-header/>
      <el-main>

        <!-- 表单 -->
        <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">

          <el-form-item label="日期">
            <el-date-picker
              v-model="form1.date"
              type="daterange"
              range-separator="~"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
            />
          </el-form-item>

          <el-form-item label="会员账号">
            <el-input placeholder="会员账号"/>
          </el-form-item>

          <el-form-item label="IP">
            <el-input placeholder="请输入ip"/>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" icon="el-icon-search" @click="onSubmit">查询</el-button>
          </el-form-item>
        </el-form>

        <!-- 表格 -->
        <el-table
          :data="tableData"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          style="width: 100%; margin-bottom: 24px">
          <el-table-column prop="date" label="日期" align="center"/>
          <el-table-column prop="account" label="账号" align="center"/>
          <el-table-column prop="ip" label="IP" align="center"/>
          <el-table-column prop="address" label="地址" align="center"/>
          <el-table-column prop="device" label="设备" align="center"/>
        </el-table>

        <!-- 分页 -->
        <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />

      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        date: ''
      },

      // tableData
      tableData: [{
        date: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1'
      }, {
        date: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2'
      }],

      // 分页
      currentPage: 4
    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
