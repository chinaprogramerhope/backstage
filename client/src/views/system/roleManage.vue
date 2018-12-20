<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="right">
      <el-form-item label="角色名称:">
        <el-input v-model="form1.roleName" placeholder=""/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>

      <el-form-item>
        <el-button @click="dialogForm1Visible = true">+ 添加</el-button>
      </el-form-item>
    </el-form>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="id" label="序号" align="center"/>
      <el-table-column prop="roleName" label="角色名称" align="center"/>
      <el-table-column prop="roleDesc" label="角色描述" align="center"/>
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

    <!-- dialog1 添加 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="添加角色" center>
      <el-form ref="ruleForm1" :model="ruleForm1" :rules="rules1">

        <el-form-item :label-width="ruleForm1.labelWidth" label="角色名称" prop="roleName">
          <el-input v-model="ruleForm1.roleName" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.labelWidth" label="角色描述:" prop="roleDesc">
          <el-input v-model="ruleForm1.roleDesc" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogForm1Visible = false">取 消</el-button>
          <el-button type="primary" @click="submitRuleForm('ruleForm1')">保 存</el-button>
        </el-form-item>
      </el-form>

    </el-dialog>

  </div>
</template>

<script>

export default {
  data() {
    return {
      form1: {
        roleName: ''
      },

      // tableData
      tableData: [{
        id: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
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
      currentPage: 4,

      // dialog1 添加
      dialogForm1Visible: false,
      ruleForm1: {
        roleName: '',
        roleDesc: '',
        labelWidth: '120px'
      },
      rules1: {
        roleName: [
          { required: true, message: '该项必填', trigger: 'blur' }
        ],
        roleDesc: [
          { required: true, message: '该项必填', trigger: 'blur' }
        ]
      }
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
    },

    // dialog
    submitRuleForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          alert('submit!')
        } else {
          this.$notify({
            title: '检验不通过, 请检查错误提示',
            message: '',
            type: 'warning'
          })
        }
      })
    }
  }
}
</script>
