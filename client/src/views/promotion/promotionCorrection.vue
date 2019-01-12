<template>
  <div>

    <!-- 表单1 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">

      <el-form-item label="用户ID:">
        <el-input v-model="form1.userId" placeholder="用户ID" style="width:250px" clearable/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="mini" icon="el-icon-search" @click="onGet">查询</el-button>
      </el-form-item>

      <el-form-item label="推广ID:">
        <el-input v-model="form1.promotionId" placeholder="请输入正确推广ID" style="width:250px" clearable/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="mini" @click="onGet">提交</el-button>
      </el-form-item>

    </el-form>

    <!-- 表单2 -->
    <el-form :inline="true" :model="form2" align="left" style="margin-top: 30px">
      <el-form-item label="日期:">
        <el-date-picker
          v-model="form2.dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          style="width:250px"
        />
      </el-form-item>

      <el-form-item label="用户ID:">
        <el-input v-model="form2.userId" placeholder="用户ID" style="width:100px" clearable/>
      </el-form-item>

      <el-form-item label="修正人:">
        <el-input v-model="form2.adminName" placeholder="修正人" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item label="修正前推广:">
        <el-input v-model="form2.promotionOld" placeholder="修正前推广ID" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item label="修正后推广:">
        <el-input v-model="form2.promotionNew" placeholder="修正后推广ID" style="width:150px" clearable/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="mini" icon="el-icon-search" @click="onGet">查询 (默认显示最近30天)</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 24px">
      <el-table-column min-width="10%" prop="userId" label="用户ID" sortable align="center"/>
      <el-table-column min-width="10%" prop="promotionId" label="目标推广ID" sortable align="center"/>
      <el-table-column min-width="10%" prop="correctionTime" label="修正时间" sortable align="center"/>
      <el-table-column min-width="10%" prop="adminName" label="修正者" sortable align="center"/>

      <el-table-column min-width="10%" prop="correctionIp" label="修正者IP" sortable align="center"/>
      <el-table-column min-width="10%" prop="promotionOld" label="原推广ID" sortable align="center"/>
      <el-table-column min-width="10%" prop="promotionNew" label="结果推广ID" sortable align="center"/>
      <el-table-column min-width="10%" prop="flag" label="修正结果" sortable align="center"/>

      <el-table-column min-width="10%" prop="discribe" label="备注" sortable align="center"/>

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
import { promotionCorrectionGetId } from '@/api/finance'
import { promotionCorrectionUpdate } from '@/api/finance'
import { promotionCorrectionGetLog } from '@/api/finance'

export default {
  data() {
    return {
      form1: {
        userId: '',
        promotionId: ''
      },
      form2: {
        dpValue1: ''
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4
    }
  },

  created() {
    // 获取修正日志
    const dateRange = this.form2.dpValue1
    const userId = this.form2.userId
    const adminName = this.form2.adminName
    const promotionOld = this.form2.promotionOld
    const promotionNew = this.form2.promotionNew

    promotionCorrectionGetLog(dateRange, userId, adminName, promotionOld, promotionNew).then(response => {
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

    // 获取修正日志
    onGet() {
      const dateRange = this.form2.dpValue1
      const userId = this.form2.userId
      const adminName = this.form2.adminName
      const promotionOld = this.form2.promotionOld
      const promotionNew = this.form2.promotionNew

      promotionCorrectionGetLog(dateRange, userId, adminName, promotionOld, promotionNew).then(response => {
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

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
