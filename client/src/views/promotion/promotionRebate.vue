<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 30px;" align="left">
      <el-form-item label="会员账号:">
        <el-input v-model="form1.vipAccount" placeholder=""/>
      </el-form-item>

      <el-form-item label="会员ID:">
        <el-input v-model="form1.vipId" placeholder=""/>
      </el-form-item>

      <el-form-item label="查询日期:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        />
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>

    </el-form>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'date', order:'descending'}"
      stripe="true"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="vipAccount" label="会员账号" align="center"/>
      <el-table-column prop="vipId" label="会员ID" align="center"/>
      <el-table-column prop="oneLvRebate" label="一级返利" align="center"/>
      <el-table-column prop="towLvRebate" label="二级返利" align="center"/>
      <el-table-column prop="threeLvRebate" label="三级返利" align="center"/>
      <el-table-column prop="totalRebate" label="合计" align="center"/>
      <el-table-column prop="rebateDate" label="返利日期" align="center"/>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

  </div>
</template>

<script>

export default {
  data() {
    return {
      form1: {
        vipAccount: '',
        vipId: '',
        dpValue1: ''
      },

      // tableData
      tableData: [{
        vipId: '2018-11-11 11:11:11',
        date: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
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
