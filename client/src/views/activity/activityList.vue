<template>

  <div>

    <el-row style="margin-bottom: 10px; margin-top: 20px;">
      <el-button type="primary">添加新活动</el-button>
    </el-row>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'activityName', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column prop="activityName" label="活动名称" align="center"/>
      <el-table-column prop="activityTime" label="活动时间" align="center"/>
      <el-table-column prop="status" label="状态" align="center"/>
      <el-table-column prop="operation" label="操作" align="center"/>
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
        selectActivityName: '',
        optionsActivityName: [{
          'label': '注册送',
          'value': 'register'
        }, {
          'label': '首充送',
          'value': 'firstCharge'
        }, {
          'label': '其他',
          'value': 'other'
        }],
        vipAccount: '',
        date: '',
        selectAuditStatus: '',
        optionsAuditStatus: [{
          'label': '待处理',
          'value': 'pend'
        }, {
          'label': '通过',
          'value': 'pass'
        }, {
          'label': '拒绝',
          'value': 'deny'
        }],
        vipId: ''
      },

      // tableData
      tableData: [{
        activityName: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1'
      }, {
        activityName: '2018-11-11 11:11:12',
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
