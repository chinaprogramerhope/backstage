<template>
  <div>

    <el-row align="left" style="margin-top: 30px">
      <el-button type="primary" @click="dialogForm1Visible = true">+ 新增等级</el-button>
    </el-row>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'lvName', order:'descending'}"
      style="width: 100%; margin-bottom: 24px"
      stripe
    >
      <el-table-column prop="name" label="等级名称" align="center"/>
      <el-table-column prop="upPrice" label="晋升条件" align="center"/>
      <el-table-column prop="userNum" label="用户数" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="scope.row.name==='普通用户'">
            <el-tag size="mini">默认等级, 不可操作</el-tag>
          </div>
          <div v-else>
            <el-button size="mini" type="primary" @click="handleEdit()">编辑</el-button>
          </div>
        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      align="center"
      layout="total, sizes, prev, pager, next, jumper"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

    <!-- dialog1 新增等级 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="添加新的会员等级">
      <el-form :model="form1">

        <el-form-item
          :label-width="form1.form1LabelWidth"
          :rules="[
            { required: true, message: '请输入等级名称', trigger: 'blur' }
          ]"
          label="等级名称:"
          prop="lvName"
        >
          <el-input v-model="form1.lvName" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="form1.form1LabelWidth"
          :rules="[
            { required: true, message: '请输入等级名称', trigger: 'blur' }
          ]"
          label="晋升条件:"
          prop="incrCondition"
        >
          <el-input v-model="form1.incrCondition" autocomplete="off" placeholder="请输入金额">
            <theme slot="prepend">￥</theme>
          </el-input>
        </el-form-item>

        <el-form-item
          :label-width="form1.form1LabelWidth"
          label="备注:"
        >
          <el-input v-model="form1.sort" :rows="2" type="textarea" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogForm1Visible = false">取 消</el-button>
          <el-button type="primary" @click="submitRuleForm('form1')">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
import { getLv } from '@/api/member'

export default {
  data() {
    return {
      form1: {
        form1LabelWidth: '120px',
        labelName: '',
        selectAutoPayOut: '是',
        sort: '',
        optionsAutoPayOut: [{
          label: '是',
          value: 'yes'
        }, {
          label: '否',
          value: 'no'
        }]
      },
      dialogForm1Visible: false,

      // tableData
      tableData: '',

      // 分页
      currentPage: 4
    }
  },

  created() {
    getLv().then(response => {
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

    // 新增
    handleAdd() {

    },

    // 编辑
    handleEdit() {

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
