<template>
  <div>

    <el-row style="margin-top: 30px; margin-bottom: 10px;">
      <el-button type="primary" @click="dialogForm1Visible = true">新增</el-button>
    </el-row>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'date', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="picName" label="图片名称" align="center"/>
      <el-table-column prop="PCPic" label="PC端图片" align="center"/>
      <el-table-column prop="H5Pic" label="H5端图片" align="center"/>
      <el-table-column prop="addTime" label="添加时间" align="center"/>
      <el-table-column prop="url" label="链接地址" align="center"/>
      <el-table-column prop="sort" label="排序" align="center"/>
      <el-table-column prop="status" label="状态" align="center"/>
      <el-table-column prop="operator" label="操作者" align="center"/>
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
    <el-dialog :visible.sync="dialogForm1Visible" title="新增轮播图" center>
      <el-form ref="ruleForm1" :model="ruleForm1">

        <el-form-item
          :label-width="ruleForm1.form1LabelWidth"
          :rules="[
            { required: true, message: '图片名称必须输入', trigger: 'blur' }
          ]"
          label="图片名称:"
          prop="picName"
        >
          <el-input v-model="ruleForm1.picName" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.form1LabelWidth" label="链接地址:">
          <el-input v-model="ruleForm1.url" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.form1LabelWidth" label="排序:">
          <el-input v-model="ruleForm1.sort" autocomplete="off" placeholder="数字越小下拉排序越靠前"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.form1LabelWidth" label="状态">
          <el-select v-model="ruleForm1.selectStatus" placeholder="">
            <el-option
              v-for="item in ruleForm1.optionsStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
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
      // tableData
      tableData: [{
        picName: '2018-11-11 11:11:11',
        date: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        picName: '2018-11-11 11:11:12',
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
        picName: '',
        selectStatus: '启用',
        form1LabelWidth: '120px',
        optionsStatus: [{
          label: '启用',
          value: 'open'
        }, {
          label: '禁用',
          value: 'close'
        }]
      }
    }
  },

  methods: {
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
