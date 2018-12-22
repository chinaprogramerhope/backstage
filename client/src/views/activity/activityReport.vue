<template>

  <div>

    <!-- 表单 -->
    <el-form :model="form1" style="margin-bottom: 10px; margin-top: 20px;" label-position="right" label-width="100px">

      <el-row :gutter="20">

        <el-col :span="6">
          <el-form-item label="活动名称">
            <el-select v-model="form1.selectActivityName" placeholder="请选择">
              <el-option
                v-for="item in optionsActivityName"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>
        </el-col>

        <el-col :span="6"><el-form-item label="会员账号"><el-input v-model="form1.vipAccount" placeholder="请输入账号"/></el-form-item></el-col>

        <el-col :span="6">
          <el-form-item label="申请日期">
            <el-date-picker
              v-model="form1.date"
              type="daterange"
              range-separator="~"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
            />
          </el-form-item>
        </el-col>

        <el-col :span="6">
          <el-form-item label="审核状态">
            <el-select v-model="form1.selectAuditStatus" placeholder="请选择">
              <el-option
                v-for="item in form1.optionsAuditStatus"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-form-item>
        </el-col>

      </el-row>

      <el-row :gutter="20">
        <el-col :span="6"><el-form-item label="会员ID"><el-input v-model="form1.vipId" placeholder="会员id"/></el-form-item></el-col>
        <el-col :span="6"><el-form-item><el-button type="primary" icon="el-icon-search" @click="onSubmit">查询</el-button></el-form-item></el-col>
      </el-row>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'activityName', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column prop="activityName" label="活动名称" align="center"/>
      <el-table-column prop="vipAccount" label="会员账号" align="center"/>
      <el-table-column prop="applyTime" label="申请时间" align="center"/>
      <el-table-column prop="activityAward" label="活动奖励" align="center"/>
      <el-table-column prop="status" label="状态" align="center"/>
      <el-table-column prop="operation" label="操作" align="center"/>
      <el-table-column prop="operator" label="操作人" sortable align="center"/>
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
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        activityName: '2018-11-11 11:11:12',
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
