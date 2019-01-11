<template>
  <div>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">
      <el-form-item label="日期:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          style="width:250px"
        />
      </el-form-item>

      <el-form-item label="编号:">
        <el-input v-model="form1.id" placeholder="编号" style="width:100px" clearable/>
      </el-form-item>

      <el-form-item label="支行名称:">
        <el-input v-model="form1.bankBranch" placeholder="支行名称" style="width:250px" clearable/>
      </el-form-item>

      <el-form-item label="收款人姓名:">
        <el-input v-model="form1.cardholderName" placeholder="收款人姓名" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item label="收款人手机:">
        <el-input v-model="form1.cardholderMobile" placeholder="收款人手机" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item label="备注关键字:">
        <el-input v-model="form1.describe" placeholder="备注关键字" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="mini" icon="el-icon-search" @click="onGet">查询 (默认显示最近30天)</el-button>
      </el-form-item>

      <!-- <el-form-item>
        <el-button type="danger" size="mini" icon="el-icon-search" @click="dialogForm1Visible = true">创建新账户</el-button>
      </el-form-item> -->

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 24px">
      <el-table-column min-width="10%" prop="addTime" label="日期" sortable align="center"/>
      <el-table-column min-width="10%" prop="agentAccount" label="推广账号" sortable align="center"/>
      <el-table-column min-width="10%" prop="money" label="金额" sortable align="center"/>
      <el-table-column min-width="10%" prop="dataType" label="类型" sortable align="center"/>

      <el-table-column min-width="10%" prop="agentbalanaceBefore" label="操作前信用金余额" sortable align="center"/>
      <el-table-column min-width="10%" prop="userId" label="用户ID" sortable align="center"/>
      <el-table-column min-width="10%" prop="content" label="备注" sortable align="center"/>

    </el-table>

    <!-- 分页 -->
    <!-- <el-row gutter="20">
      <el-col :span="10" style="text-align: center">
        <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </el-col> -->

  </div>
</template>

<script>
import { payAccountManageGet } from '@/api/finance'
import { payAccountManageCreate } from '@/api/finance'
import { payAccountManageCashWithdrawal } from '@/api/finance'

export default {
  data() {
    return {
      form1: {
        dpValue1: ''
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4,

      // dialog1 添加
      dialogForm1Visible: false,
      passGameName: '',
      dialogForm1: {
        form1LabelWidth: '120px',

        // 客户类型
        selectCustomerType: 1,
        optionsCustomerType: [{
          label: '个人',
          value: 1
        }, {
          label: '企业',
          value: 2
        }],

        // 资产类型
        selectAccountType: 1,
        optionsAccountType: [{
          label: '借记卡',
          value: 1
        }, {
          label: '企业对公账户',
          value: 2
        }]
      }
    }
  },

  created() {
    const dateRange = this.form1.dpValue1
    const bankcardNo = this.form1.bankcardNo
    const bankBranch = this.form1.bankBranch
    const cardholderName = this.form1.cardholderName
    const cardholderMobile = this.form1.cardholderMobile
    const describe = this.form1.describe

    payAccountManageGet(dateRange, bankcardNo, bankBranch, cardholderName, cardholderMobile, describe).then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败',
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 查询
    onGet() {
      const dateRange = this.form1.dpValue1
      const bankcardNo = this.form1.bankcardNo
      const bankBranch = this.form1.bankBranch
      const cardholderName = this.form1.cardholderName
      const cardholderMobile = this.form1.cardholderMobile
      const describe = this.form1.describe

      payAccountManageGet(dateRange, bankcardNo, bankBranch, cardholderName, cardholderMobile, describe).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 表单必填验证 todo 前端验证没用, 应该是没有定义全局rules
    submitRuleForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) { // 创建新账号
          const bankcardNo = this.dialogForm1.bankcardNo
          const bankBranch = this.dialogForm1.bankBranch
          const cardholderName = this.dialogForm1.cardholderName
          const cardholderMobile = this.dialogForm1.cardholderMobile

          const headquartersBankId = this.dialogForm1.headquartersBankId
          const issueBankId = this.dialogForm1.issueBankId
          const describe = this.dialogForm1.describe
          const customerType = this.dialogForm1.customerType

          const accountType = this.dialogForm1.accountType

          payAccountManageCreate(bankcardNo, bankBranch, cardholderName, cardholderMobile,
            headquartersBankId, issueBankId, describe, customerType,
            accountType).then(response => {
            if (response.code === 0) {
              this.tableData = response.data
            } else {
              this.$notify({
                title: '创建新账户失败',
                message: '',
                type: 'error'
              })
            }
          })
        } else {
          this.$notify({
            title: '检验不通过, 请检查错误提示',
            message: '',
            type: 'warning'
          })
        }
      })
    },

    // 提现
    handleCashWithdrawal() {
      payAccountManageCashWithdrawal().then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '提现成功',
            message: '',
            type: 'success'
          })
        } else {
          this.$notify({
            title: '提现失败',
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
